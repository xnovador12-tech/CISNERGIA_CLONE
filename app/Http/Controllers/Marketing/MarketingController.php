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
            
            // Extraer todos los comentarios para identificar la plataforma de cada Lead
            $allComments = collect();
            $allPosts->each(function($post) use ($allComments) {
                if(isset($post['comments']['data'])) {
                    foreach($post['comments']['data'] as $comment) {
                        $comment['is_ig'] = $post['is_ig'];
                        $allComments->push($comment);
                    }
                }
            });

            // ENRIQUECIMIENTO DE PERFILES PÚBLICOS
            // Tomamos solo el top 15 global para no saturar la API de Meta y evitar lentitud
            $enrichedLeads = collect($metaData['top_leads'])->take(15)->map(function($lead) use ($allComments) {
                // Buscamos el primer comentario de este lead para saber si es de IG o FB
                $firstComment = $allComments->firstWhere('from.id', $lead['id']);
                $isIg = $firstComment['is_ig'] ?? false;
                
                // Llamamos a nuestro Service con Fallback Seguro
                $perfil = $isIg 
                    ? $this->metaService->getInstagramProfile($lead['id'])
                    : $this->metaService->getFacebookProfile($lead['id']);
                    
                $lead['perfil'] = $perfil;
                $lead['is_ig'] = $isIg;
                
                return $lead;
            });

            // Separamos los leads enriquecidos por plataforma
            $fbData = [
                'top_leads' => $enrichedLeads->where('is_ig', false)->take(10)->values()->all(),
                'recent_posts' => $fbPostsArray
            ];

            $igData = [
                'top_leads' => $enrichedLeads->where('is_ig', true)->take(10)->values()->all(),
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
            'is_ig' => 'boolean'
        ]);

        try {
            $isIg = $request->input('is_ig', false);
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
                        $comment['is_ig'] = $post['is_ig']; // Guardamos la bandera para el perfil
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

            // ENRIQUECER MEJOR COMENTARIO
            $mejorComentario = $allComments->sortByDesc('like_count')->first();
            if ($mejorComentario && isset($mejorComentario['from']['id'])) {
                $mejorComentario['perfil'] = $mejorComentario['is_ig']
                    ? $this->metaService->getInstagramProfile($mejorComentario['from']['id'])
                    : $this->metaService->getFacebookProfile($mejorComentario['from']['id']);
            }

            // ENRIQUECER TOP FAN
            $topFanGroup = $allComments->whereNotNull('from.id')
                                  ->groupBy('from.id')
                                  ->sortByDesc(fn($g) => $g->count())
                                  ->first();
            
            $topFan = $topFanGroup ? $topFanGroup->first() : null;
            if ($topFan) {
                $topFan['perfil'] = $topFan['is_ig']
                    ? $this->metaService->getInstagramProfile($topFan['from']['id'])
                    : $this->metaService->getFacebookProfile($topFan['from']['id']);
                
                // Agregamos el conteo total para la vista
                $topFan['total_comentarios'] = $topFanGroup->count();
            }

            return view('ADMINISTRADOR.MARKETING.metricas_globales', [
                'allComments' => $allComments,
                'mejorComentario' => $mejorComentario,
                'topFan' => $topFan,
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
        if (!Storage::disk('public')->exists('logos_email')) {
            Storage::disk('public')->makeDirectory('logos_email');
        }

        $files = Storage::disk('public')->files('logos_email');
        
        $logos = array_map(function($file) {
            return [
                'path' => $file,
                'url' => asset('storage/' . $file) 
            ];
        }, $files);

        return view('ADMINISTRADOR.MARKETING.emails.index', compact('logos'));
    }

    public function uploadLogo(Request $request): JsonResponse
    {
        $request->validate(['logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120']);
        
        $path = $request->file('logo')->store('logos_email', 'public');
        
        return response()->json([
            'success' => true, 
            'path' => $path,
            'url' => asset('storage/' . $path)
        ]);
    }

    public function deleteLogo(Request $request): JsonResponse
    {
        $path = $request->input('path');
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Archivo no encontrado'], 400);
    }

    public function sendEmailCampaign(Request $request): RedirectResponse
    {
        $request->validate([
            'asunto'        => 'required|string|max:255',
            'destinatarios' => 'required|string',
            'contenido'     => 'required|string',
            'adjuntos.*'    => 'nullable|file|max:10240',
        ]);

        Log::info('MarketingController: sendEmailCampaign iniciado', [
            'asunto'        => $request->asunto,
            'destinatarios' => $request->destinatarios,
            'logo_path'     => $request->input('logo_path') ?? 'ninguno',
            'tiene_adjuntos'=> $request->hasFile('adjuntos'),
            'usuario'       => auth()->user()?->email ?? 'desconocido',
        ]);

        try {
            $recipients = array_filter(
                array_map('trim', explode(',', $request->destinatarios)),
                fn($e) => !empty($e)
            );

            if (empty($recipients)) {
                Log::warning('MarketingController: No se encontraron destinatarios válidos en la cadena.');
                return redirect()->back()->with('error', 'No se encontraron destinatarios válidos.');
            }

            $logoPath = $request->input('logo_path') ?: null;

            $adjuntos = [];
            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    if (!$file->isValid()) {
                        Log::warning('MarketingController: Archivo adjunto inválido omitido.', [
                            'original_name' => $file->getClientOriginalName(),
                            'error'         => $file->getErrorMessage(),
                        ]);
                        continue;
                    }
                    $adjuntos[] = [
                        'path' => $file->getRealPath(),
                        'name' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                    ];
                    Log::info('MarketingController: Adjunto preparado: ' . $file->getClientOriginalName());
                }
            }

            $resultado = $this->emailService->dispatchCampaign(
                $recipients,
                $request->asunto,
                $request->contenido,
                $logoPath,
                $adjuntos
            );

            Log::info('MarketingController: Campaña procesada', $resultado);

            $tipo = $resultado['success'] ? 'success' : 'warning';
            return redirect()->route('admin.marketing.emails')->with($tipo, $resultado['mensaje']);

        } catch (\Exception $e) {
            Log::error('MarketingController: Excepción inesperada en sendEmailCampaign', [
                'error'     => $e->getMessage(),
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ]);
            return redirect()->back()->with('error', 'Error inesperado al procesar la campaña. Revisa los logs.');
        }
    }
}