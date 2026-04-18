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
use Illuminate\Support\Facades\Storage; 

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
            'message' => 'required|string',
            'is_ig' => 'boolean' // Recibimos de qué red viene
        ]);

        try {
            $isIg = $request->input('is_ig', false);
            // Pasamos null como senderId porque somos nosotros, e $isIg para que sepa la ruta de Meta
            $result = $this->metaService->publishComment($request->object_id, $request->message, null, $isIg);
            
            Log::info("MarketingController: Comentario publicado en {$request->object_id}");
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            Log::error('MarketingController Error al publicar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al publicar en Meta.'], 500);
        }
    }

    public function deleteComment($id): JsonResponse
    {
        Log::warning("MarketingController: Intentando eliminar comentario ID: $id");

        try {
            // ¡OJO AQUÍ! Llamamos al Service, NO usamos client() directo
            $success = $this->metaService->deleteComment($id);
            
            if ($success) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Meta rechazó la eliminación (revisa logs).'], 400);
            }
        } catch (\Exception $e) {
            Log::error('MarketingController Error al eliminar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error en el servidor.'], 500);
        }
    }
    // NUEVA FUNCIÓN: Para el botón de "Me gusta"
    public function toggleLike(Request $request, $id): JsonResponse
    {
        $request->validate([
            'is_ig' => 'required|boolean',
            'currently_liked' => 'required|boolean',
        ]);

        try {
            $result = $this->metaService->toggleLike($id, $request->is_ig, $request->currently_liked);
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('MarketingController Error Toggle Like: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al reaccionar en Meta.'], 500);
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


    // 1. REEMPLAZA EL MÉTODO emails()
    public function emails(): View
    {
        // Leemos los logos que hay en storage/app/public/logos_email
        $files = Storage::disk('public')->files('logos_email');
        $logos = array_map(function($file) {
            return ['path' => $file];
        }, $files);

        return view('ADMINISTRADOR.MARKETING.emails.index', compact('logos'));
    }

    // 2. NUEVOS MÉTODOS PARA GESTIONAR LOGOS
// Cambia solo el método uploadLogo en tu Controlador
    public function uploadLogo(Request $request): JsonResponse
    {
        $request->validate(['logo' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        
        // Guardamos en la carpeta logos_email dentro de public
        $path = $request->file('logo')->store('logos_email', 'public');
        
        return response()->json([
            'success' => true, 
            'path' => $path,
            'url' => asset('storage/' . $path) // Mandamos la URL lista para el JS
        ]);
    }
    public function deleteLogo(Request $request): JsonResponse
    {
        $path = $request->input('path');
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    // 3. REEMPLAZA EL MÉTODO sendEmailCampaign()
    public function sendEmailCampaign(Request $request): RedirectResponse
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'destinatarios' => 'required|string',
            'contenido' => 'required|string',
            'adjuntos.*' => 'nullable|file|max:10240' // Max 10MB por archivo
        ]);

        try {
            $recipients = explode(',', $request->destinatarios);
            $logoPath = $request->input('logo_path'); // Puede ser null si no seleccionó nada
            
            // Recolectar archivos adjuntos temporalmente
            $adjuntos = [];
            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    $adjuntos[] = [
                        'path' => $file->getRealPath(),
                        'name' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType()
                    ];
                }
            }
            
            $resultado = $this->emailService->dispatchCampaign(
                array_map('trim', $recipients),
                $request->asunto,
                $request->contenido,
                $logoPath,
                $adjuntos
            );
            
            return redirect()->route('admin.marketing.emails')->with('success', $resultado['mensaje']);
        } catch (\Exception $e) {
            Log::error('MarketingController Error Campaña Email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al enviar los correos.');
        }
    }
}