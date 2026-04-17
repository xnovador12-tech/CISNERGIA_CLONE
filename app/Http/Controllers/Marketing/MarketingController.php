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

    /**
     * Dashboard Principal: Radar Meta con Paginación y Media
     */
    public function metricas(Request $request): View
    {
        Log::info('MarketingController: Iniciando carga de Radar Meta.');
        
        $periodo = $request->get('periodo', 'all'); 
        $search = $request->get('search');
        // Reducimos el límite a 20 para optimizar la carga inicial como pediste
        $limit = 20; 

        try {
            // Llamamos al service con el nuevo límite
            $metaData = $this->metaService->getOrganicLeadScoring($limit);
            $allPosts = collect($metaData['recent_posts']);

            // Filtro de búsqueda en la colección
            if ($search) {
                $allPosts = $allPosts->filter(function($post) use ($search) {
                    return str_contains(strtolower($post['message']), strtolower($search));
                });
            }

            // Separación por canales (FB / IG)
            $fbPosts = $allPosts->where('is_ig', false)->values();
            $igPosts = $allPosts->where('is_ig', true)->values();

            $fbData = [
                'total_posts_analizados' => $fbPosts->count(),
                'top_leads' => $this->filterLeadsByPeriod($metaData['top_leads'], $periodo),
                'recent_posts' => $fbPosts,
                'paging' => $metaData['paging'] ?? null
            ];

            $igData = [
                'total_posts_analizados' => $igPosts->count(),
                'top_leads' => $this->filterLeadsByPeriod($metaData['top_leads'], $periodo),
                'recent_posts' => $igPosts
            ];

            return view('ADMINISTRADOR.MARKETING.index', compact('fbData', 'igData', 'periodo', 'search'));

        } catch (\Exception $e) {
            Log::error('MarketingController Error en Metricas: ' . $e->getMessage());
            return view('ADMINISTRADOR.MARKETING.index')->with('error', 'No se pudo sincronizar la data con Meta API.');
        }
    }

    /**
     * Acción: Responder a comentario públicamente
     */
    public function reply(Request $request): JsonResponse
    {
        $request->validate([
            'comment_id' => 'required|string',
            'message' => 'required|string'
        ]);

        try {
            $result = $this->metaService->replyToComment($request->comment_id, $request->message);
            Log::info("MarketingController: Respuesta enviada con éxito al comentario {$request->comment_id}");
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            Log::error('MarketingController Error al responder: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al publicar respuesta.'], 500);
        }
    }

    /**
     * Acción: Eliminar cualquier comentario (Propio o de terceros)
     */
    public function deleteComment($id): JsonResponse
    {
        Log::warning("MarketingController: Ejecutando eliminación de comentario ID: $id");

        try {
            $success = $this->metaService->deleteComment($id);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            Log::error('MarketingController Error al eliminar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar el comentario.'], 500);
        }
    }

    /**
     * ECOSISTEMA EMAIL MARKETING
     */
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

    /**
     * Filtro de Leads (Segmentación por Periodo)
     */
    private function filterLeadsByPeriod(array $leads, string $periodo): array
    {
        if ($periodo === 'all') return $leads;

        // Aquí la lógica se puede extender usando Carbon según la fecha de interacción
        // Por ahora mantenemos la colección íntegra para no perder prospectos
        return $leads; 
    }
}