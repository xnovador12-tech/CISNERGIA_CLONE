<?php

namespace Database\Seeders;

use App\Models\Prospecto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProspectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendedor = User::first();

        $prospectos = [
            // ==================== MANUALES (registrados por vendedores) ====================
            [
                'nombre' => 'Carlos',
                'apellidos' => 'Mendoza Ríos',
                'tipo_persona' => 'natural',
                'dni' => '45678912',
                'email' => 'carlos.mendoza@gmail.com',
                'telefono' => '014567890',
                'celular' => '987654321',
                'direccion' => 'Av. La Molina 1234, La Molina',
                'origen' => 'sitio_web',
                'tipo_interes' => 'producto',
                'segmento' => 'residencial',
                'estado' => 'calificado',
                'nivel_interes' => 'alto',
                'urgencia' => 'corto_plazo',
                'observaciones' => 'Interesado en sistema solar para su casa. Tiene espacio en el techo.',
            ],
            [
                'nombre' => 'María Elena',
                'apellidos' => 'Torres Gutiérrez',
                'tipo_persona' => 'natural',
                'dni' => '78912345',
                'email' => 'maria.torres@hotmail.com',
                'celular' => '956789012',
                'direccion' => 'Jr. Las Flores 567, San Borja',
                'origen' => 'referido',
                'tipo_interes' => 'producto',
                'segmento' => 'residencial',
                'estado' => 'contactado',
                'nivel_interes' => 'muy_alto',
                'urgencia' => 'inmediata',
                'observaciones' => 'Referida por cliente Juan Pérez. Muy interesada en reducir su factura eléctrica.',
            ],
            [
                'nombre' => 'Roberto',
                'apellidos' => 'Sánchez Vargas',
                'tipo_persona' => 'natural',
                'dni' => '12345678',
                'email' => 'roberto.sanchez@yahoo.com',
                'celular' => '923456789',
                'direccion' => 'Calle Los Pinos 890, Surco',
                'origen' => 'redes_sociales',
                'tipo_interes' => 'producto',
                'segmento' => 'residencial',
                'estado' => 'nuevo',
                'nivel_interes' => 'medio',
                'urgencia' => 'mediano_plazo',
                'observaciones' => 'Contactó por Facebook Ads. Quiere más información.',
            ],
            [
                'nombre' => 'Luis Alberto',
                'apellidos' => 'García Fernández',
                'razon_social' => 'Restaurante El Buen Sabor S.A.C.',
                'tipo_persona' => 'juridica',
                'ruc' => '20567891234',
                'email' => 'lgarcia@elbuensabor.com.pe',
                'telefono' => '012345678',
                'celular' => '945678901',
                'direccion' => 'Av. Javier Prado Este 4521, San Isidro',
                'origen' => 'llamada',
                'tipo_interes' => 'producto',
                'segmento' => 'comercial',
                'estado' => 'calificado',
                'nivel_interes' => 'muy_alto',
                'urgencia' => 'inmediata',
                'observaciones' => 'Llamó interesado después de ver publicidad. Alto consumo eléctrico mensual.',
            ],
            [
                'nombre' => 'Patricia',
                'apellidos' => 'Vega Luna',
                'razon_social' => 'Clínica Dental Sonrisas E.I.R.L.',
                'tipo_persona' => 'juridica',
                'ruc' => '20456789123',
                'email' => 'patricia.vega@clinicasonrisas.com',
                'telefono' => '013456789',
                'celular' => '934567890',
                'direccion' => 'Av. Brasil 2345, Magdalena',
                'origen' => 'sitio_web',
                'tipo_interes' => 'producto',
                'segmento' => 'comercial',
                'estado' => 'contactado',
                'nivel_interes' => 'alto',
                'urgencia' => 'corto_plazo',
                'observaciones' => 'Llenó formulario web. Se le envió cotización preliminar, esperando respuesta.',
            ],
            [
                'nombre' => 'Fernando',
                'apellidos' => 'Castillo Morales',
                'razon_social' => 'Textiles del Norte S.A.',
                'tipo_persona' => 'juridica',
                'ruc' => '20345678912',
                'email' => 'fcastillo@textilesdelnorte.com.pe',
                'telefono' => '014567891',
                'celular' => '912345678',
                'direccion' => 'Av. Industrial 567, Ate',
                'origen' => 'referido',
                'tipo_interes' => 'producto',
                'segmento' => 'industrial',
                'estado' => 'calificado',
                'nivel_interes' => 'muy_alto',
                'urgencia' => 'corto_plazo',
                'observaciones' => 'Referido por la Cámara de Comercio. Proyecto grande, alto potencial.',
            ],
            [
                'nombre' => 'Ricardo',
                'apellidos' => 'Huamán Quispe',
                'razon_social' => 'Agrícola Huamán Hermanos',
                'tipo_persona' => 'juridica',
                'ruc' => '20123456789',
                'email' => 'rhuaman@agricolahuaman.com',
                'celular' => '956123456',
                'direccion' => 'Fundo Santa Rosa, Km 45 Panamericana Sur, Cañete',
                'origen' => 'sitio_web',
                'tipo_interes' => 'producto',
                'segmento' => 'agricola',
                'estado' => 'contactado',
                'nivel_interes' => 'muy_alto',
                'urgencia' => 'inmediata',
                'observaciones' => 'Necesita sistema de bombeo solar para riego.',
            ],
            [
                'nombre' => 'Andrea',
                'apellidos' => 'López Martínez',
                'tipo_persona' => 'natural',
                'dni' => '34567891',
                'email' => 'andrea.lopez@gmail.com',
                'celular' => '978123456',
                'direccion' => 'Av. El Sol 234, Chaclacayo',
                'origen' => 'redes_sociales',
                'tipo_interes' => 'producto',
                'segmento' => 'residencial',
                'estado' => 'descartado',
                'nivel_interes' => 'bajo',
                'urgencia' => 'largo_plazo',
                'observaciones' => 'Vive en departamento sin acceso a techo. Solo consulta informativa.',
            ],
            [
                'nombre' => 'Pedro',
                'apellidos' => 'Díaz Romero',
                'tipo_persona' => 'natural',
                'dni' => '56789123',
                'email' => 'pedro.diaz@outlook.com',
                'celular' => '967891234',
                'direccion' => 'Calle Los Álamos 567, Miraflores',
                'origen' => 'referido',
                'tipo_interes' => 'servicio',
                'segmento' => 'residencial',
                'estado' => 'descartado',
                'motivo_descarte' => 'Ya contrató con la competencia',
                'nivel_interes' => 'alto',
            ],
            [
                'nombre' => 'Gustavo',
                'apellidos' => 'Paredes Soto',
                'tipo_persona' => 'natural',
                'dni' => '41236578',
                'email' => 'gparedes@gmail.com',
                'celular' => '943215678',
                'direccion' => 'Calle Las Magnolias 321, San Miguel',
                'origen' => 'llamada',
                'tipo_interes' => 'servicio',
                'segmento' => 'residencial',
                'estado' => 'calificado',
                'nivel_interes' => 'muy_alto',
                'urgencia' => 'corto_plazo',
                'observaciones' => 'Tiene sistema solar de 3kW. Quiere contratar mantenimiento preventivo.',
            ],

            // ==================== ECOMMERCE (registrados automáticamente desde la tienda) ====================
            [
                'nombre' => 'Javier',
                'apellidos' => 'Rodríguez Peña',
                'tipo_persona' => 'natural',
                'dni' => '73456812',
                'email' => 'jrodriguez.pena@gmail.com',
                'celular' => '991234567',
                'direccion' => 'Av. Primavera 450, Surquillo',
                'origen' => 'ecommerce',
                'tipo_interes' => 'producto',
                'segmento' => 'residencial',
                'estado' => 'nuevo',
                'observaciones' => 'Se registró en la tienda online. Agregó paneles solares 550W y un inversor a favoritos.',
                'user_id' => null, // Sin vendedor asignado (registro automático)
            ],
            [
                'nombre' => 'Lucía',
                'apellidos' => 'Fernández Castillo',
                'tipo_persona' => 'natural',
                'dni' => '48923156',
                'email' => 'lucia.fc89@hotmail.com',
                'celular' => '945678321',
                'direccion' => 'Jr. Los Olivos 789, Los Olivos',
                'origen' => 'ecommerce',
                'tipo_interes' => 'producto',
                'segmento' => 'residencial',
                'estado' => 'nuevo',
                'observaciones' => 'Registro automático desde e-commerce. Exploró kits solares residenciales y añadió productos al carrito.',
                'user_id' => null,
            ],
            [
                'nombre' => 'Diego',
                'apellidos' => 'Quispe Mamani',
                'razon_social' => 'Minimarket Don Diego E.I.R.L.',
                'tipo_persona' => 'juridica',
                'ruc' => '20712345678',
                'email' => 'dquispe@minimarketdondiego.com',
                'celular' => '952167834',
                'direccion' => 'Av. Túpac Amaru 3456, Comas',
                'origen' => 'ecommerce',
                'tipo_interes' => 'producto',
                'segmento' => 'comercial',
                'estado' => 'contactado',
                'nivel_interes' => 'alto',
                'observaciones' => 'Se registró como empresa en la tienda online. Navegó productos de iluminación solar y paneles comerciales. Se contactó al día siguiente y mostró mucho interés.',
                'user_id' => null,
            ],
        ];

        foreach ($prospectos as $index => $data) {
            $codigo = 'PROSP-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            
            // Los prospectos de ecommerce no tienen vendedor asignado
            $userId = array_key_exists('user_id', $data) && $data['user_id'] === null 
                ? null 
                : $vendedor?->id;
            
            // Limpiar user_id del array de datos si existe
            unset($data['user_id']);

            Prospecto::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo' => $codigo,
                    'slug' => Str::slug($data['nombre'] . '-' . $codigo),
                    'user_id' => $userId,
                    'fecha_primer_contacto' => now()->subDays(rand(1, 60)),
                    'fecha_ultimo_contacto' => now()->subDays(rand(0, 15)),
                    'fecha_proximo_contacto' => now()->addDays(rand(1, 14)),
                ])
            );
        }
    }
}
