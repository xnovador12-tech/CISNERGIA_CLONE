<?php

namespace App\Console\Commands;

use App\Models\CampanaEmailProgramada;
use App\Services\EmailMarketingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EnviarCampanasProgramadas extends Command
{
    protected $signature = 'emails:enviar-programados {--lote=20 : Cantidad máxima de campañas por corrida}';

    protected $description = 'Procesa las campañas de email programadas cuya fecha de envío ya llegó.';

    public function handle(EmailMarketingService $emailService): int
    {
        @set_time_limit(290);

        $lote = (int) $this->option('lote');
        $campanas = CampanaEmailProgramada::pendientes()->limit($lote)->get();

        if ($campanas->isEmpty()) {
            $this->info('No hay campañas pendientes.');
            return Command::SUCCESS;
        }

        $this->info("Procesando {$campanas->count()} campaña(s) programada(s)...");

        foreach ($campanas as $campana) {
            $this->procesar($campana, $emailService);
        }

        return Command::SUCCESS;
    }

    private function procesar(CampanaEmailProgramada $campana, EmailMarketingService $emailService): void
    {
        $bloqueado = CampanaEmailProgramada::where('id', $campana->id)
            ->where('estado', CampanaEmailProgramada::ESTADO_PENDIENTE)
            ->update([
                'estado' => CampanaEmailProgramada::ESTADO_PROCESANDO,
                'updated_at' => now(),
            ]);

        if ($bloqueado === 0) {
            return;
        }

        $campana->refresh();

        try {
            $adjuntos = $this->prepararAdjuntos($campana->adjuntos ?? []);

            $resultado = $emailService->dispatchCampaign(
                $campana->destinatarios,
                $campana->asunto,
                $campana->contenido_html,
                $campana->logo_path,
                $adjuntos
            );

            $estadoFinal = $this->resolverEstadoFinal($resultado);

            $campana->update([
                'estado' => $estadoFinal,
                'enviados_count' => $resultado['enviados'] ?? 0,
                'fallidos_count' => ($resultado['fallidos'] ?? 0) + ($resultado['invalidos'] ?? 0),
                'detalle_error' => $resultado['fallidos_detalle']
                    ? implode(', ', $resultado['fallidos_detalle'])
                    : null,
                'procesado_en' => now(),
            ]);

            $this->limpiarAdjuntos($campana->adjuntos ?? []);

            $this->line("  ✔ Campaña #{$campana->id} → {$estadoFinal} ({$resultado['enviados']} enviados, {$resultado['fallidos']} fallidos)");

        } catch (\Exception $e) {
            Log::error("EnviarCampanasProgramadas error en campaña {$campana->id}: " . $e->getMessage());
            $campana->update([
                'estado' => CampanaEmailProgramada::ESTADO_FALLIDO,
                'detalle_error' => $e->getMessage(),
                'procesado_en' => now(),
            ]);
            $this->error("  ✘ Campaña #{$campana->id} → fallido: " . $e->getMessage());
        }
    }

    private function prepararAdjuntos(array $adjuntosGuardados): array
    {
        $adjuntos = [];
        foreach ($adjuntosGuardados as $a) {
            if (empty($a['path']) || !Storage::disk('public')->exists($a['path'])) {
                continue;
            }
            $adjuntos[] = [
                'path' => Storage::disk('public')->path($a['path']),
                'name' => $a['name'] ?? 'adjunto',
                'mime' => $a['mime'] ?? 'application/octet-stream',
            ];
        }
        return $adjuntos;
    }

    private function limpiarAdjuntos(array $adjuntosGuardados): void
    {
        foreach ($adjuntosGuardados as $a) {
            if (!empty($a['path']) && Storage::disk('public')->exists($a['path'])) {
                Storage::disk('public')->delete($a['path']);
            }
        }
    }

    private function resolverEstadoFinal(array $resultado): string
    {
        if (($resultado['enviados'] ?? 0) === 0) return CampanaEmailProgramada::ESTADO_FALLIDO;
        if (($resultado['fallidos'] ?? 0) === 0) return CampanaEmailProgramada::ESTADO_ENVIADO;
        return CampanaEmailProgramada::ESTADO_PARCIAL;
    }
}
