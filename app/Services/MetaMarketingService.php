<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

    private function client(?string $overrideToken = null)
    {
        return Http::withoutVerifying()
            ->withToken($overrideToken ?? $this->token)
            ->baseUrl("https://graph.facebook.com/{$this->version}/")
            ->timeout(15);
    }

    public function getOrganicLeadScoring(int $limit = 20): array
    {
        Log::info("MetaService: Iniciando peticiones. ID_PAGINA: {$this->pageId}");

        // 1. OBTENER TOKEN DE PÁGINA
        $tokenResponse = $this->client()->get("{$this->pageId}", ['fields' => 'access_token']);
        $pageAccessToken = $tokenResponse->json('access_token');

        if (!$pageAccessToken) {
            Log::error("MetaService: No se pudo obtener el Token de Página.");
            $pageAccessToken = $this->token;
        }

        // 2. OBTENER FEED DE FACEBOOK (Con full_picture para ver la imagen del post)
        $fbResponse = $this->client($pageAccessToken)->get("{$this->pageId}/feed", [
            'fields' => 'id,message,created_time,full_picture,comments{from,message,like_count}',
            'limit' => $limit
        ]);

        $fbPosts = collect($fbResponse->json('data') ?? [])->map(function ($post) {
            return [
                'id' => $post['id'],
                'message' => $post['message'] ?? 'Publicación sin texto (Facebook)',
                'full_picture' => $post['full_picture'] ?? null,
                'created_time' => $post['created_time'] ?? now(),
                'comments' => $post['comments'] ?? null,
                'is_ig' => false
            ];
        });

        // 3. OBTENER MEDIA DE INSTAGRAM (Con media_url para ver la imagen/video)
        $igPosts = collect();
        if ($this->instagramId) {
            $igResponse = $this->client($pageAccessToken)->get("{$this->instagramId}/media", [
                'fields' => 'id,caption,timestamp,media_url,comments{from,message,like_count}',
                'limit' => $limit
            ]);

            $igPosts = collect($igResponse->json('data') ?? [])->map(function ($post) {
                return [
                    'id' => $post['id'],
                    'message' => $post['caption'] ?? 'Publicación sin texto (Instagram)',
                    'full_picture' => $post['media_url'] ?? null,
                    'created_time' => $post['timestamp'] ?? now(),
                    'comments' => $post['comments'] ?? null,
                    'is_ig' => true
                ];
            });
        }

        // 4. UNIFICACIÓN Y LEAD SCORING
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
                'total_likes_recibidos' => $userComments->sum('like_count'),
                'score_interes' => $userComments->count() + ($userComments->sum('like_count') * 2)
            ];
        })->sortByDesc('score_interes')->values()->take(50);

        return [
            'total_posts_analizados' => $allPosts->count(),
            'top_leads' => $topLeads->toArray(),
            'recent_posts' => $allPosts->toArray(),
            'paging' => $fbResponse->json('paging') // Guardamos el cursor para el "Siguiente"
        ];
    }

    public function processWebhook(array $payload): void
    {
        if (!isset($payload['entry'])) return;
        foreach ($payload['entry'] as $entry) {
            if (isset($entry['changes'])) {
                foreach ($entry['changes'] as $change) {
                    broadcast(new \App\Events\MetaActivityEvent($change))->toOthers();
                }
            }
        }
    }

    public function replyToComment(string $commentId, string $message): array
    {
        $tokenResponse = $this->client()->get("{$this->pageId}", ['fields' => 'access_token']);
        $pageAccessToken = $tokenResponse->json('access_token') ?? $this->token;

        $response = $this->client($pageAccessToken)->post("{$commentId}/comments", [
            'message' => $message
        ]);

        return $response->json();
    }

    public function deleteComment(string $commentId): bool
    {
        $tokenResponse = $this->client()->get("{$this->pageId}", ['fields' => 'access_token']);
        $pageAccessToken = $tokenResponse->json('access_token') ?? $this->token;

        $response = $this->client($pageAccessToken)->delete($commentId);
        
        Log::info("MetaService: Eliminación de comentario", ['id' => $commentId, 'success' => $response->successful()]);
        return $response->successful();
    }
}