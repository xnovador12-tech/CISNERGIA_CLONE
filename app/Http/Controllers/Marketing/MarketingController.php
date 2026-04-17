<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\MetaMarketingService;
use App\Services\EmailMarketingService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class MarketingController extends Controller
{
    public function __construct(
        private readonly MetaMarketingService $metaService,
        private readonly EmailMarketingService $emailService
    ) {}

    public function metricas(Request $request): View
    {
        $search = $request->get('search');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');
        $limit = 30;

        try {
            $metaData = $this->metaService->getOrganicLeadScoring($limit);
            $allPosts = collect($metaData['recent_posts']);

            if ($fechaInicio && $fechaFin) {
                $allPosts = $allPosts->filter(function($post) use ($fechaInicio, $fechaFin) {
                    $date = \Carbon\Carbon::parse($post['created_time'])->startOfDay();
                    return $date->between($fechaInicio, $fechaFin);
                });
            }

            if ($search) {
                $allPosts = $allPosts->filter(function($post) use ($search) {
                    return str_contains(strtolower($post['message'] ?? ''), strtolower($search));
                });
            }

            $fbPostsArray = $allPosts->filter(fn($post) => $post['is_ig'] === false)->values()->all();
            $igPostsArray = $allPosts->filter(fn($post) => $post['is_ig'] === true)->values()->all();
            $allLeads = collect($metaData['top_leads']);

            $fbData = [
                'top_leads' => $allLeads->take(10)->all(),
                'recent_posts' => $fbPostsArray
            ];

            $igData = [
                'top_leads' => $allLeads->skip(10)->take(10)->all(),
                'recent_posts' => $igPostsArray
            ];

            return view('ADMINISTRADOR.MARKETING.index', compact('fbData', 'igData', 'search', 'fechaInicio', 'fechaFin'));

        } catch (\Exception $e) {
            Log::error('Marketing Error: ' . $e->getMessage());
            return view('ADMINISTRADOR.MARKETING.index')->with('error', 'Fallo conexión Meta.');
        }
    }

    public function publishComment(Request $request): JsonResponse
    {
        $request->validate([
            'object_id' => 'required|string', 
            'message' => 'required|string'
        ]);

        try {
            $result = $this->metaService->publishComment($request->object_id, $request->message);
            Log::info("MarketingController: Comentario publicado en {$request->object_id}");
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            Log::error('MarketingController Error al publicar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al publicar en Meta.'], 500);
        }
    }

    public function deleteComment($id): JsonResponse
    {
        Log::warning("MarketingController: Eliminando comentario ID: $id");

        try {
            $success = $this->metaService->deleteComment($id);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            Log::error('MarketingController Error al eliminar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar el comentario.'], 500);
        }
    }

    public function metricasGlobales(Request $request): View
    {
        $canal = $request->get('canal', 'all');
        $keyword = $request->get('keyword');
        
        try {
            $metaData = $this->metaService->getOrganicLeadScoring(50);
            $allPosts = collect($metaData['recent_posts']);
            $allComments = collect();

            foreach ($allPosts as $post) {
                if (isset($post['comments']['data'])) {
                    foreach ($post['comments']['data'] as $comment) {
                        $comment['platform'] = $post['is_ig'] ? 'Instagram' : 'Facebook';
                        $comment['post_id'] = $post['id'];
                        $comment['post_message'] = $post['message'] ?? '';
                        // Doble protección para asegurar que 'message' y 'name' existan en la vista
                        $comment['message'] = $comment['message'] ?? $comment['text'] ?? 'Sin mensaje';
                        if (!isset($comment['from']['name'])) {
                            $comment['from']['name'] = $comment['from']['username'] ?? 'Usuario';
                        }
                        $allComments->push($comment);
                    }
                }
            }

            if ($canal !== 'all') {
                $isIg = ($canal === 'ig');
                $allComments = $allComments->where('is_ig', $isIg);
            }

            if ($keyword) {
                $allComments = $allComments->filter(function($c) use ($keyword) {
                    return str_contains(strtolower($c['message'] ?? ''), strtolower($keyword));
                });
            }

            $mejorComentario = $allComments->sortByDesc('like_count')->first();
            $topFan = $allComments->whereNotNull('from.id')
                                  ->groupBy('from.id')
                                  ->sortByDesc(fn($g) => $g->count())
                                  ->first();

            return view('ADMINISTRADOR.MARKETING.metricas_globales', [
                'allComments' => $allComments,
                'mejorComentario' => $mejorComentario,
                'topFan' => $topFan ? $topFan->first() : null,
                'canal' => $canal,
                'keyword' => $keyword
            ]);

        } catch (\Exception $e) {
            Log::error('MarketingController Error Global Metrics: ' . $e->getMessage());
            return view('ADMINISTRADOR.MARKETING.index')->with('error', 'Error al procesar KPIs.');
        }
    }

    public function emails(): View
    {
        return view('ADMINISTRADOR.MARKETING.emails.index');
    }

    public function sendEmailCampaign(Request $request): RedirectResponse
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'destinatarios' => 'required|string',
            'contenido' => 'required|string'
        ]);

        try {
            $recipients = explode(',', $request->destinatarios);
            $resultado = $this->emailService->dispatchCampaign(
                array_map('trim', $recipients),
                $request->asunto,
                $request->contenido
            );
            return redirect()->route('admin.marketing.emails')->with('success', $resultado['mensaje']);
        } catch (\Exception $e) {
            Log::error('MarketingController Error Campaña Email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error crítico al enviar los correos.');
        }
    }
}