<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\MetaMarketingService;
use App\Services\EmailMarketingService;
use App\Services\MarketingLeadService;
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
        private readonly EmailMarketingService $emailService,
        private readonly MarketingLeadService $leadService,
    ) {}

    public function convertirLeadAProspecto(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'plataforma' => 'required|in:facebook,instagram',
            'social_id' => 'required|string|max:120',
            'nombre_social' => 'nullable|string|max:150',
            'puntaje_interes' => 'nullable|integer|min:0',
            'comentario_origen' => 'nullable|string|max:1000',
        ]);

        try {
            $lead = $this->leadService->convertirAProspecto($datos);
            $yaExistia = $lead->wasRecentlyCreated === false && $lead->prospecto_id !== null && $lead->wasChanged() === false;

            return response()->json([
                'success' => true,
                'ya_existia' => $yaExistia,
                'prospecto' => [
                    'id' => $lead->prospecto?->id,
                    'codigo' => $lead->prospecto?->codigo,
                    'nombre' => $lead->prospecto?->nombre,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('MarketingController convertirLeadAProspecto: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se pudo registrar el prospecto.'], 500);
        }
    }

    public function metricas(Request $request): View
    {
        try {
            $data = $this->buildRadarData($request, enrichLeads: true);
            return view('ADMINISTRADOR.MARKETING.index', $data);
        } catch (\Exception $e) {
            Log::error('Marketing Error: ' . $e->getMessage());
            return view('ADMINISTRADOR.MARKETING.index')->with('error', 'Fallo conexión Meta.');
        }
    }

    public function metricasData(Request $request): JsonResponse
    {
        try {
            $data = $this->buildRadarData($request, enrichLeads: false);
            return response()->json([
                'success' => true,
                'fb' => [
                    'posts' => $data['fbData']['recent_posts'],
                    'total' => count($data['fbData']['recent_posts']),
                ],
                'ig' => [
                    'posts' => $data['igData']['recent_posts'],
                    'total' => count($data['igData']['recent_posts']),
                ],
                'filtros' => [
                    'search' => $data['search'],
                    'canal' => $data['canal'],
                    'fecha_inicio' => $data['fechaInicio'],
                    'fecha_fin' => $data['fechaFin'],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Marketing Error (data): ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Fallo conexión Meta.'], 500);
        }
    }

    private function buildRadarData(Request $request, bool $enrichLeads): array
    {
        $search = trim((string) $request->input('search'));
        $canal = $request->input('canal', 'all');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $metaData = $this->metaService->getOrganicLeadScoring(30);
        $posts = collect($metaData['recent_posts']);

        $posts = $this->aplicarFiltrosPosts($posts, $search, $canal, $fechaInicio, $fechaFin);

        $fbPosts = $posts->where('is_ig', false)->values()->all();
        $igPosts = $posts->where('is_ig', true)->values()->all();

        $allComments = $this->extraerComentarios($posts);

        $topLeads = $enrichLeads
            ? $this->enriquecerLeads(collect($metaData['top_leads'])->take(15), $allComments)
            : collect();

        return [
            'fbData' => [
                'top_leads' => $topLeads->where('is_ig', false)->take(10)->values()->all(),
                'recent_posts' => $fbPosts,
            ],
            'igData' => [
                'top_leads' => $topLeads->where('is_ig', true)->take(10)->values()->all(),
                'recent_posts' => $igPosts,
            ],
            'search' => $search,
            'canal' => $canal,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ];
    }

    private function aplicarFiltrosPosts($posts, ?string $search, string $canal, ?string $fechaInicio, ?string $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            $posts = $posts->filter(function ($post) use ($fechaInicio, $fechaFin) {
                $date = \Carbon\Carbon::parse($post['created_time'])->startOfDay();
                return $date->between($fechaInicio, $fechaFin);
            });
        }

        if ($search !== '') {
            $posts = $posts->filter(fn($post) => str_contains(
                strtolower($post['message'] ?? ''),
                strtolower($search)
            ));
        }

        if ($canal === 'fb') {
            $posts = $posts->where('is_ig', false);
        } elseif ($canal === 'ig') {
            $posts = $posts->where('is_ig', true);
        }

        return $posts;
    }

    private function extraerComentarios($posts)
    {
        $comments = collect();
        $posts->each(function ($post) use ($comments) {
            foreach ($post['comments']['data'] ?? [] as $comment) {
                $comment['is_ig'] = $post['is_ig'];
                $comments->push($comment);
            }
        });
        return $comments;
    }

    private function enriquecerLeads($leads, $allComments)
    {
        return $leads->map(function ($lead) use ($allComments) {
            $firstComment = $allComments->firstWhere('from.id', $lead['id']);
            $isIg = $firstComment['is_ig'] ?? false;

            $lead['perfil'] = $isIg
                ? $this->metaService->getInstagramProfile($lead['id'])
                : $this->metaService->getFacebookProfile($lead['id']);
            $lead['is_ig'] = $isIg;

            return $lead;
        });
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
        $canal = $request->input('canal', 'all');
        $keyword = $request->input('keyword');
        
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
            'enviar_el'     => 'nullable|date',
            'adjuntos.*'    => 'nullable|file|max:10240',
        ]);

        try {
            $recipients = array_filter(
                array_map('trim', explode(',', $request->destinatarios)),
                fn($e) => !empty($e)
            );

            if (empty($recipients)) {
                return redirect()->back()->with('error', 'No se encontraron destinatarios válidos.');
            }

            $logoPath = $request->input('logo_path') ?: null;
            $enviarEl = $request->filled('enviar_el') ? \Carbon\Carbon::parse($request->input('enviar_el')) : null;
            $esProgramado = $enviarEl && $enviarEl->isFuture();

            if ($esProgramado) {
                return $this->programarCampania($request, $recipients, $logoPath, $enviarEl);
            }

            return $this->enviarCampaniaInmediata($request, $recipients, $logoPath);

        } catch (\Exception $e) {
            Log::error('MarketingController: Excepción en sendEmailCampaign', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
            return redirect()->back()->with('error', 'Error inesperado. Revisa los logs.');
        }
    }

    private function enviarCampaniaInmediata(Request $request, array $recipients, ?string $logoPath): RedirectResponse
    {
        $adjuntos = [];
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $file) {
                if (!$file->isValid()) continue;
                $adjuntos[] = [
                    'path' => $file->getRealPath(),
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ];
            }
        }

        $resultado = $this->emailService->dispatchCampaign(
            $recipients,
            $request->asunto,
            $request->contenido,
            $logoPath,
            $adjuntos
        );

        $tipo = $resultado['success'] ? 'success' : 'warning';
        return redirect()->route('admin.marketing.emails')->with($tipo, $resultado['mensaje']);
    }

    private function programarCampania(Request $request, array $recipients, ?string $logoPath, \Carbon\Carbon $enviarEl): RedirectResponse
    {
        $adjuntosGuardados = [];
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $file) {
                if (!$file->isValid()) continue;
                $path = $file->store('campanas_email/adjuntos', 'public');
                $adjuntosGuardados[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ];
            }
        }

        \App\Models\CampanaEmailProgramada::create([
            'asunto' => $request->asunto,
            'destinatarios' => $recipients,
            'contenido_html' => $request->contenido,
            'logo_path' => $logoPath,
            'adjuntos' => $adjuntosGuardados,
            'enviar_el' => $enviarEl,
            'estado' => \App\Models\CampanaEmailProgramada::ESTADO_PENDIENTE,
            'user_id' => auth()->id(),
        ]);

        $fechaTexto = $enviarEl->locale('es')->translatedFormat('d M Y, H:i');
        return redirect()->route('admin.marketing.emails')
            ->with('success', "Campaña programada para el {$fechaTexto}. Se enviará automáticamente.");
    }
}