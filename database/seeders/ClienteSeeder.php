<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Oportunidad;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Crea clientes a partir de oportunidades GANADAS.
     *
     * Flujo real del negocio:
     *   Prospecto → Oportunidad (ganada) → Cliente
     *
     * Los datos del cliente se heredan del prospecto vinculado a la oportunidad.
     * Esto garantiza trazabilidad completa en el CRM.
     *
     * Dependencias: ProspectoSeeder, OportunidadSeeder (deben ejecutarse antes)
     */
    public function run(): void
    {
        $ganadas = Oportunidad::where('etapa', 'ganada')
            ->with('prospecto')
            ->orderBy('fecha_cierre_real')
            ->get();

        if ($ganadas->isEmpty()) {
            $this->command->warn('⚠️ No hay oportunidades ganadas. Se omitió ClienteSeeder.');
            $this->command->warn('   Ejecuta OportunidadSeeder primero.');
            return;
        }

        $sede = \App\Models\Sede::first();

        foreach ($ganadas as $index => $oportunidad) {
            $prospecto = $oportunidad->prospecto;

            if (!$prospecto) {
                $this->command->warn("  ⚠️ Oportunidad {$oportunidad->codigo} sin prospecto. Omitida.");
                continue;
            }

            // Determinar origen del cliente según origen del prospecto
            $origen = $prospecto->origen === 'ecommerce' ? 'ecommerce' : 'directo';

            // Determinar segmento: priorizar tipo_proyecto de la oportunidad
            $segmento = $oportunidad->tipo_proyecto ?? $prospecto->segmento ?? 'residencial';

            // Determinar estado (último cliente inactivo para variedad en demo)
            $estado = ($index === $ganadas->count() - 1 && $ganadas->count() > 3)
                ? 'inactivo'
                : 'activo';

            $cliente = Cliente::create([
                // Datos personales (heredados del prospecto)
                'nombre'       => $prospecto->nombre,
                'apellidos'    => $prospecto->apellidos,
                'razon_social' => $prospecto->razon_social,
                'tipo_persona' => $prospecto->tipo_persona,
                'ruc'          => $prospecto->ruc,
                'dni'          => $prospecto->dni,

                // Contacto
                'email'    => $prospecto->email,
                'telefono' => $prospecto->telefono,
                'celular'  => $prospecto->celular,

                // Ubicación
                'direccion'   => $prospecto->direccion,
                'distrito_id' => $prospecto->distrito_id ?? null,

                // Clasificación
                'origen'   => $origen,
                'segmento' => $segmento,
                'estado'   => $estado,

                // Trazabilidad CRM
                'prospecto_id' => $prospecto->id,
                'vendedor_id'  => $oportunidad->user_id,
                'user_id'      => $oportunidad->user_id,

                // Fechas
                'fecha_primera_compra' => $oportunidad->fecha_cierre_real,

                // Adicional
                'sede_id'       => $sede?->id,
                'observaciones' => "Convertido desde oportunidad {$oportunidad->codigo}. Proyecto: {$oportunidad->nombre}.",
            ]);

            $tipoLabel = $prospecto->tipo_persona === 'juridica'
                ? ($prospecto->razon_social ?? $prospecto->nombre)
                : "{$prospecto->nombre} {$prospecto->apellidos}";

            $this->command->info("  👤 {$cliente->codigo} → {$tipoLabel} [{$segmento}, {$origen}, {$estado}]");
        }

        $total = Cliente::count();
        $activos = Cliente::where('estado', 'activo')->count();
        $ecommerce = Cliente::where('origen', 'ecommerce')->count();

        $this->command->info("✅ {$total} clientes creados ({$activos} activos, {$ecommerce} e-commerce)");
        $this->command->info("   Todos vinculados a oportunidades ganadas con prospecto trazable.");
    }
}
