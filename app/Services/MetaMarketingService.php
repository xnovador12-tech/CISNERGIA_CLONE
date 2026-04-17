<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Events\MetaActivityEvent;

class MetaMarketingService
{
    private string $version;
    private string $pageId;
    private string $instagramId;
    private string $token;

    public function __construct()
    {
        $this->version = config('services.meta.version') ?? 'v19.0';
        $this->pageId = config('services.meta.page_id') ?? '';
        $this->instagramId = config('services.meta.instagram_id') ?? '';
        $this->token = config('services.meta.token') ?? '';
    }

    private function getPageToken(): string
    {
        $response = Http::withoutVerifying()->get("https://graph.facebook.com/{$this->version}/{$this->pageId}", [
            'fields' => 'access_token',
            'access_token' => $this->token
        ]);
        return $response->json('access_token') ?? $this->token;
    }

    private function client(?string $overrideToken = null)
    {
        return Http::withoutVerifying()
            ->withToken($overrideToken ?? $this->getPageToken())
            ->baseUrl("https://graph.facebook.com/{$this->version}/")
            ->timeout(15);
    }

    public function getOrganicLeadScoring(int $limit = 20): array
    {
        Log::info("MetaService: Cargando Radar Pro. ID_PAGINA: {$this->pageId}");
        $pageAccessToken = $this->getPageToken();

        // 1. FEED FACEBOOK
        $fbResponse = $this->client($pageAccessToken)->get("{$this->pageId}/feed", [
            'fields' => 'id,message,created_time,full_picture,permalink_url,comments.summary(true){from,message,created_time,like_count,comments{from,message,created_time}},insights.metric(post_impressions_unique){values}',
            'limit' => $limit
        ]);

        $fbPosts = collect($fbResponse->json('data') ?? [])->map(function ($post) {
            return [
                'id' => $post['id'],
                'message' => $post['message'] ?? 'Sin texto',
                'full_picture' => $post['full_picture'] ?? null,
                'permalink' => $post['permalink_url'] ?? null,
                'created_time' => $post['created_time'] ?? now(),
                'alcance' => $post['insights']['data'][0]['values'][0]['value'] ?? 'N/D',
                'comment_count' => $post['comments']['summary']['total_count'] ?? 0,
                'comments' => $post['comments'] ?? null,
                'is_ig' => false
            ];
        });

        // 2. MEDIA INSTAGRAM (Pedimos 'text' en lugar de 'message')
        $igPosts = collect();
        if ($this->instagramId) {
            $igResponse = $this->client($pageAccessToken)->get("{$this->instagramId}/media", [
                'fields' => 'id,caption,timestamp,media_url,permalink,comments.summary(true){from,text,timestamp,like_count,replies{from,text,timestamp}},insights.metric(reach){values}',
                'limit' => $limit
            ]);

            $igPosts = collect($igResponse->json('data') ?? [])->map(function ($post) {
                // NORMALIZACIÓN: Convertimos la estructura de IG para que sea idéntica a FB
                $comments = $post['comments'] ?? null;
                if (isset($comments['data'])) {
                    foreach ($comments['data'] as &$c) {
                        $c['message'] = $c['text'] ?? 'Sin texto';
                        $c['created_time'] = $c['timestamp'] ?? now();
                        if (!isset($c['from']['name'])) {
                            $c['from']['name'] = $c['from']['username'] ?? 'Usuario IG';
                        }
                        
                        // Normalizamos las respuestas (replies) de IG
                        if (isset($c['replies']['data'])) {
                            foreach ($c['replies']['data'] as &$r) {
                                $r['message'] = $r['text'] ?? 'Sin texto';
                                $r['created_time'] = $r['timestamp'] ?? now();
                                if (!isset($r['from']['name'])) {
                                    $r['from']['name'] = $r['from']['username'] ?? 'Cisnergia';
                                }
                            }
                        }
                    }
                }

                return [
                    'id' => $post['id'],
                    'message' => $post['caption'] ?? 'Sin texto',
                    'full_picture' => $post['media_url'] ?? null,
                    'permalink' => $post['permalink'] ?? null,
                    'created_time' => $post['timestamp'] ?? now(),
                    'alcance' => $post['insights']['data'][0]['values'][0]['value'] ?? 'N/D',
                    'comment_count' => $post['comments']['summary']['total_count'] ?? 0,
                    'comments' => $comments,
                    'is_ig' => true
                ];
            });
        }

        $allPosts = $fbPosts->merge($igPosts);
        $allComments = collect();

        $allPosts->each(function ($post) use ($allComments) {
            if (isset($post['comments']['data'])) {
                foreach ($post['comments']['data'] as $comment) {
                    $comment['is_ig'] = $post['is_ig']; 
                    $allComments->push($comment);
                }
            }
        });

        $topLeads = $allComments->whereNotNull('from.id')->groupBy('from.id')->map(function ($userComments) {
            $firstComment = $userComments->first();
            return [
                'id' => $firstComment['from']['id'],
                'nombre' => $firstComment['from']['name'] ?? 'Usuario Meta',
                'total_comentarios' => $userComments->count(),
                'score_interes' => $userComments->count() + ($userComments->sum('like_count') * 2)
            ];
        })->sortByDesc('score_interes')->values()->take(50);

        return [
            'total_posts_analizados' => $allPosts->count(),
            'top_leads' => $topLeads->toArray(),
            'recent_posts' => $allPosts->toArray(),
            'paging' => $fbResponse->json('paging')
        ];
    }

    public function publishComment(string $objectId, string $message): array
    {
        $response = $this->client()->post("{$objectId}/comments", [
            'message' => $message
        ]);

        Log::info("MetaService: Comentario/Respuesta publicada en ID: {$objectId}");
        return $response->json();
    }

    public function processWebhook(array $payload): void
    {
        if (!isset($payload['entry'])) return;
        foreach ($payload['entry'] as $entry) {
            if (isset($entry['changes'])) {
                foreach ($entry['changes'] as $change) {
                    broadcast(new MetaActivityEvent($change))->toOthers();
                }
            }
        }
    }

    public function deleteComment(string $commentId): bool
    {
        $response = $this->client()->delete($commentId);
        Log::info("MetaService: Intento de borrado de comentario ID: {$commentId}");
        return $response->successful();
    }
}