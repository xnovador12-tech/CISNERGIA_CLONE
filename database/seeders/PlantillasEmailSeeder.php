<?php

namespace Database\Seeders;

use App\Models\EtiquetaPlantilla;
use App\Models\PlantillaEmail;
use Illuminate\Database\Seeder;

class PlantillasEmailSeeder extends Seeder
{
    public function run(): void
    {
        $etiquetas = collect([
            ['nombre' => 'Cotizaciones', 'color' => '#1C3146'],
            ['nombre' => 'Bienvenida', 'color' => '#20c997'],
            ['nombre' => 'Postventa', 'color' => '#fd7e14'],
            ['nombre' => 'Precios', 'color' => '#6f42c1'],
        ])->mapWithKeys(function ($etiqueta) {
            $modelo = EtiquetaPlantilla::firstOrCreate(
                ['nombre' => $etiqueta['nombre']],
                ['color' => $etiqueta['color']]
            );
            return [$etiqueta['nombre'] => $modelo->id];
        });

        $plantillas = [
            [
                'nombre' => 'Cotización solar estándar',
                'asunto' => 'Cotización Cisnergia Perú — Sistema Fotovoltaico',
                'descripcion' => 'Plantilla base para envío de cotizaciones de sistemas solares.',
                'etiquetas' => ['Cotizaciones', 'Precios'],
                'contenido_html' => <<<HTML
<p>Estimado(a),</p>
<p>Le adjuntamos la cotización solicitada para su <strong>sistema fotovoltaico</strong>. El equipo de <strong>Cisnergia Perú</strong> ha preparado una propuesta a medida de sus necesidades energéticas.</p>
<p>Incluye:</p>
<ul>
  <li>Paneles solares de alta eficiencia</li>
  <li>Inversor con garantía extendida</li>
  <li>Instalación y puesta en marcha</li>
  <li>Soporte postventa</li>
</ul>
<p>Quedamos atentos a cualquier consulta o ajuste.</p>
<p>Atentamente,<br><strong>Equipo Comercial Cisnergia Perú</strong></p>
HTML,
            ],
            [
                'nombre' => 'Bienvenida nuevo cliente',
                'asunto' => '¡Bienvenido(a) a Cisnergia Perú!',
                'descripcion' => 'Mensaje de bienvenida para clientes recién captados.',
                'etiquetas' => ['Bienvenida'],
                'contenido_html' => <<<HTML
<p>Hola,</p>
<p>¡Bienvenido(a) a la familia <strong>Cisnergia Perú</strong>! Estamos felices de acompañarte en tu camino hacia una <strong>energía más limpia y eficiente</strong>.</p>
<p>En las próximas horas un asesor te contactará para coordinar los siguientes pasos. Mientras tanto, te invitamos a visitar nuestra web y conocer todas nuestras soluciones.</p>
<p>Si tienes cualquier consulta, responde directamente a este correo.</p>
<p>Saludos,<br><strong>Cisnergia Perú</strong></p>
HTML,
            ],
            [
                'nombre' => 'Recordatorio de mantenimiento',
                'asunto' => 'Recordatorio: tu mantenimiento solar está próximo',
                'descripcion' => 'Para clientes con mantenimiento programado en los siguientes días.',
                'etiquetas' => ['Postventa'],
                'contenido_html' => <<<HTML
<p>Estimado(a) cliente,</p>
<p>Le recordamos que su <strong>mantenimiento preventivo</strong> de su sistema fotovoltaico Cisnergia está programado para los próximos días.</p>
<p>Beneficios de mantener al día su mantenimiento:</p>
<ul>
  <li>Maximiza la producción de energía</li>
  <li>Detecta problemas antes de que sean costosos</li>
  <li>Conserva la garantía del equipo</li>
</ul>
<p>Si necesita reprogramar, por favor responda este correo o llámenos.</p>
<p>Atentamente,<br><strong>Soporte Técnico Cisnergia Perú</strong></p>
HTML,
            ],
        ];

        foreach ($plantillas as $datos) {
            $plantilla = PlantillaEmail::firstOrCreate(
                ['nombre' => $datos['nombre']],
                [
                    'asunto' => $datos['asunto'],
                    'descripcion' => $datos['descripcion'],
                    'contenido_html' => $datos['contenido_html'],
                    'es_global' => true,
                ]
            );

            $ids = collect($datos['etiquetas'])->map(fn($n) => $etiquetas[$n])->all();
            $plantilla->etiquetas()->sync($ids);
        }
    }
}
