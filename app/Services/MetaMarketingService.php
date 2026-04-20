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
            'fields' => 'id,message,created_time,full_picture,permalink_url,comments.summary(true){from,message,created_time,user_likes,like_count,comments{from,message,created_time}},insights.metric(post_impressions_unique){values}',
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

        // 2. MEDIA INSTAGRAM
        $igPosts = collect();
        if ($this->instagramId) {
            $igResponse = $this->client($pageAccessToken)->get("{$this->instagramId}/media", [
                'fields' => 'id,caption,timestamp,media_url,permalink,comments.summary(true){from,text,timestamp,like_count,replies{from,text,timestamp}},insights.metric(reach){values}',
                'limit' => $limit
            ]);

            $igPosts = collect($igResponse->json('data') ?? [])->map(function ($post) {
                $comments = $post['comments'] ?? null;
                if (isset($comments['data'])) {
                    foreach ($comments['data'] as &$c) {
                        $c['message'] = $c['text'] ?? 'Sin texto';
                        $c['created_time'] = $c['timestamp'] ?? now();
                        if (!isset($c['from']['name'])) {
                            $c['from']['name'] = $c['from']['username'] ?? 'Usuario IG';
                        }
                        
                        $c['user_likes'] = false;

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

    public function publishComment(string $objectId, string $message, ?string $senderId = null, bool $isIg = false): array
    {
        $myId = $isIg ? $this->instagramId : $this->pageId;
        
        if ($senderId && $senderId === $myId) {
            Log::warning("MetaService: Intento de responder a un comentario propio. Operación bloqueada por seguridad.");
            return ['success' => false, 'message' => 'El sistema no permite que la página se responda a sí misma.'];
        }

        $endpoint = $isIg ? "{$objectId}/replies" : "{$objectId}/comments";

        $response = $this->client()->post($endpoint, [
            'message' => $message
        ]);

        if ($response->successful()) {
            Log::info("MetaService: Comentario publicado en ID: {$objectId}");
            return ['success' => true, 'data' => $response->json()];
        }

        Log::error("MetaService Error Publish: " . $response->body());
        return ['success' => false, 'message' => 'Error al publicar la respuesta en Meta.'];
    }

    public function toggleLike(string $commentId, bool $isIg, bool $currentlyLiked): array
    {
        if ($isIg) {
            Log::warning("MetaService: API de IG no soporta likes en comentarios.");
            return [
                'success' => false, 
                'message' => 'Instagram no permite dar "Me encanta" a comentarios desde su API. Solo puedes responder o eliminar.'
            ];
        }

        if ($currentlyLiked) {
            $response = $this->client()->delete("{$commentId}/likes");
            $action = 'unlike';
        } else {
            $response = $this->client()->post("{$commentId}/likes");
            $action = 'like';
        }

        if ($response->successful()) {
            Log::info("MetaService: Acción '{$action}' ejecutada en Facebook ID: {$commentId}");
            return ['success' => true, 'action' => $action];
        }

        Log::error("MetaService Error Toggle Like: " . $response->body());
        return ['success' => false, 'message' => 'Error al reaccionar en Facebook.'];
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
        
        if ($response->successful()) {
            Log::info("MetaService: Comentario ID {$commentId} eliminado con éxito de la red social.");
            return true;
        }

        Log::error("MetaService Error al eliminar ID {$commentId}: " . $response->body());
        return false;
    }

    // =========================================================================
    // NUEVOS MÉTODOS: PERFILES PÚBLICOS (FALLBACK IMPLEMENTADO)
    // =========================================================================

    /**
     * Obtiene el perfil público de Facebook vía PSID.
     * Retorna un fallback seguro si Meta aún no aprueba los permisos.
     */
    public function getFacebookProfile(string $psid): array
    {
        try {
            $response = $this->client()->get($psid, [
                'fields' => 'first_name,last_name,profile_pic'
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("Meta FB Profile Denied/Error (A la espera de App Review) para PSID {$psid}: " . $response->body());

            // FALLBACK SEGURO
            return [
                'first_name' => 'Usuario',
                'last_name' => 'Facebook',
                'profile_pic' => null,
                'is_fallback' => true
            ];

        } catch (\Exception $e) {
            Log::error("Excepción obteniendo FB Profile: " . $e->getMessage());
            return ['first_name' => 'Usuario', 'last_name' => 'Facebook', 'profile_pic' => null, 'is_fallback' => true];
        }
    }

    /**
     * Obtiene el perfil público de Instagram vía IGSID.
     * Retorna un fallback seguro si Meta aún no aprueba los permisos.
     */
    public function getInstagramProfile(string $igsid): array
    {
        try {
            $response = $this->client()->get($igsid, [
                'fields' => 'name,profile_pic'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $partes = explode(' ', $data['name'] ?? 'Usuario Instagram', 2);
                
                return [
                    'first_name' => $partes[0],
                    'last_name' => $partes[1] ?? '',
                    'profile_pic' => $data['profile_pic'] ?? null
                ];
            }

            Log::warning("Meta IG Profile Denied/Error (A la espera de App Review) para IGSID {$igsid}: " . $response->body());

            // FALLBACK SEGURO
            return [
                'first_name' => 'Usuario',
                'last_name' => 'Instagram',
                'profile_pic' => null,
                'is_fallback' => true
            ];

        } catch (\Exception $e) {
            Log::error("Excepción obteniendo IG Profile: " . $e->getMessage());
            return ['first_name' => 'Usuario', 'last_name' => 'Instagram', 'profile_pic' => null, 'is_fallback' => true];
        }
    }
}