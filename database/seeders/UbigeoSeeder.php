<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UbigeoSeeder extends Seeder
{
    /**
     * Seeder para Departamentos, Provincias y Distritos del Perú
     */
    public function run(): void
    {
        // Departamentos del Perú
        $departamentos = [
            ['codigo' => '01', 'nombre' => 'Amazonas'],
            ['codigo' => '02', 'nombre' => 'Áncash'],
            ['codigo' => '03', 'nombre' => 'Apurímac'],
            ['codigo' => '04', 'nombre' => 'Arequipa'],
            ['codigo' => '05', 'nombre' => 'Ayacucho'],
            ['codigo' => '06', 'nombre' => 'Cajamarca'],
            ['codigo' => '07', 'nombre' => 'Callao'],
            ['codigo' => '08', 'nombre' => 'Cusco'],
            ['codigo' => '09', 'nombre' => 'Huancavelica'],
            ['codigo' => '10', 'nombre' => 'Huánuco'],
            ['codigo' => '11', 'nombre' => 'Ica'],
            ['codigo' => '12', 'nombre' => 'Junín'],
            ['codigo' => '13', 'nombre' => 'La Libertad'],
            ['codigo' => '14', 'nombre' => 'Lambayeque'],
            ['codigo' => '15', 'nombre' => 'Lima'],
            ['codigo' => '16', 'nombre' => 'Loreto'],
            ['codigo' => '17', 'nombre' => 'Madre de Dios'],
            ['codigo' => '18', 'nombre' => 'Moquegua'],
            ['codigo' => '19', 'nombre' => 'Pasco'],
            ['codigo' => '20', 'nombre' => 'Piura'],
            ['codigo' => '21', 'nombre' => 'Puno'],
            ['codigo' => '22', 'nombre' => 'San Martín'],
            ['codigo' => '23', 'nombre' => 'Tacna'],
            ['codigo' => '24', 'nombre' => 'Tumbes'],
            ['codigo' => '25', 'nombre' => 'Ucayali'],
        ];

        foreach ($departamentos as $depto) {
            DB::table('departamentos')->insert([
                'codigo' => $depto['codigo'],
                'nombre' => $depto['nombre'],
                'slug' => Str::slug($depto['nombre']),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Provincias principales (Lima y alrededores para energía solar)
        $provincias = [
            // Lima
            ['codigo' => '1501', 'nombre' => 'Lima', 'departamento_codigo' => '15'],
            ['codigo' => '1502', 'nombre' => 'Barranca', 'departamento_codigo' => '15'],
            ['codigo' => '1503', 'nombre' => 'Cajatambo', 'departamento_codigo' => '15'],
            ['codigo' => '1504', 'nombre' => 'Canta', 'departamento_codigo' => '15'],
            ['codigo' => '1505', 'nombre' => 'Cañete', 'departamento_codigo' => '15'],
            ['codigo' => '1506', 'nombre' => 'Huaral', 'departamento_codigo' => '15'],
            ['codigo' => '1507', 'nombre' => 'Huarochirí', 'departamento_codigo' => '15'],
            ['codigo' => '1508', 'nombre' => 'Huaura', 'departamento_codigo' => '15'],
            ['codigo' => '1509', 'nombre' => 'Oyón', 'departamento_codigo' => '15'],
            ['codigo' => '1510', 'nombre' => 'Yauyos', 'departamento_codigo' => '15'],
            // Callao
            ['codigo' => '0701', 'nombre' => 'Callao', 'departamento_codigo' => '07'],
            // Arequipa
            ['codigo' => '0401', 'nombre' => 'Arequipa', 'departamento_codigo' => '04'],
            ['codigo' => '0402', 'nombre' => 'Camaná', 'departamento_codigo' => '04'],
            ['codigo' => '0403', 'nombre' => 'Caravelí', 'departamento_codigo' => '04'],
            ['codigo' => '0404', 'nombre' => 'Castilla', 'departamento_codigo' => '04'],
            ['codigo' => '0405', 'nombre' => 'Caylloma', 'departamento_codigo' => '04'],
            ['codigo' => '0406', 'nombre' => 'Condesuyos', 'departamento_codigo' => '04'],
            ['codigo' => '0407', 'nombre' => 'Islay', 'departamento_codigo' => '04'],
            ['codigo' => '0408', 'nombre' => 'La Unión', 'departamento_codigo' => '04'],
            // Ica
            ['codigo' => '1101', 'nombre' => 'Ica', 'departamento_codigo' => '11'],
            ['codigo' => '1102', 'nombre' => 'Chincha', 'departamento_codigo' => '11'],
            ['codigo' => '1103', 'nombre' => 'Nazca', 'departamento_codigo' => '11'],
            ['codigo' => '1104', 'nombre' => 'Palpa', 'departamento_codigo' => '11'],
            ['codigo' => '1105', 'nombre' => 'Pisco', 'departamento_codigo' => '11'],
            // La Libertad
            ['codigo' => '1301', 'nombre' => 'Trujillo', 'departamento_codigo' => '13'],
            ['codigo' => '1302', 'nombre' => 'Ascope', 'departamento_codigo' => '13'],
            ['codigo' => '1303', 'nombre' => 'Bolívar', 'departamento_codigo' => '13'],
            ['codigo' => '1304', 'nombre' => 'Chepén', 'departamento_codigo' => '13'],
            // Lambayeque
            ['codigo' => '1401', 'nombre' => 'Chiclayo', 'departamento_codigo' => '14'],
            ['codigo' => '1402', 'nombre' => 'Ferreñafe', 'departamento_codigo' => '14'],
            ['codigo' => '1403', 'nombre' => 'Lambayeque', 'departamento_codigo' => '14'],
            // Piura
            ['codigo' => '2001', 'nombre' => 'Piura', 'departamento_codigo' => '20'],
            ['codigo' => '2002', 'nombre' => 'Ayabaca', 'departamento_codigo' => '20'],
            ['codigo' => '2003', 'nombre' => 'Huancabamba', 'departamento_codigo' => '20'],
            ['codigo' => '2004', 'nombre' => 'Morropón', 'departamento_codigo' => '20'],
            ['codigo' => '2005', 'nombre' => 'Paita', 'departamento_codigo' => '20'],
            ['codigo' => '2006', 'nombre' => 'Sullana', 'departamento_codigo' => '20'],
            ['codigo' => '2007', 'nombre' => 'Talara', 'departamento_codigo' => '20'],
            ['codigo' => '2008', 'nombre' => 'Sechura', 'departamento_codigo' => '20'],
            // Cusco
            ['codigo' => '0801', 'nombre' => 'Cusco', 'departamento_codigo' => '08'],
            ['codigo' => '0802', 'nombre' => 'Acomayo', 'departamento_codigo' => '08'],
            ['codigo' => '0803', 'nombre' => 'Anta', 'departamento_codigo' => '08'],
            ['codigo' => '0804', 'nombre' => 'Calca', 'departamento_codigo' => '08'],
            // Tacna
            ['codigo' => '2301', 'nombre' => 'Tacna', 'departamento_codigo' => '23'],
            ['codigo' => '2302', 'nombre' => 'Candarave', 'departamento_codigo' => '23'],
            ['codigo' => '2303', 'nombre' => 'Jorge Basadre', 'departamento_codigo' => '23'],
            ['codigo' => '2304', 'nombre' => 'Tarata', 'departamento_codigo' => '23'],
            // Moquegua
            ['codigo' => '1801', 'nombre' => 'Mariscal Nieto', 'departamento_codigo' => '18'],
            ['codigo' => '1802', 'nombre' => 'General Sánchez Cerro', 'departamento_codigo' => '18'],
            ['codigo' => '1803', 'nombre' => 'Ilo', 'departamento_codigo' => '18'],
        ];

        foreach ($provincias as $prov) {
            $deptoId = DB::table('departamentos')->where('codigo', $prov['departamento_codigo'])->value('id');
            DB::table('provincias')->insert([
                'codigo' => $prov['codigo'],
                'nombre' => $prov['nombre'],
                'slug' => Str::slug($prov['nombre']),
                'departamento_id' => $deptoId,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Distritos de Lima Metropolitana (zonas con alto potencial solar)
        $distritosLima = [
            // Lima Centro
            ['codigo' => '150101', 'nombre' => 'Lima', 'provincia_codigo' => '1501'],
            ['codigo' => '150102', 'nombre' => 'Ancón', 'provincia_codigo' => '1501'],
            ['codigo' => '150103', 'nombre' => 'Ate', 'provincia_codigo' => '1501'],
            ['codigo' => '150104', 'nombre' => 'Barranco', 'provincia_codigo' => '1501'],
            ['codigo' => '150105', 'nombre' => 'Breña', 'provincia_codigo' => '1501'],
            ['codigo' => '150106', 'nombre' => 'Carabayllo', 'provincia_codigo' => '1501'],
            ['codigo' => '150107', 'nombre' => 'Chaclacayo', 'provincia_codigo' => '1501'],
            ['codigo' => '150108', 'nombre' => 'Chorrillos', 'provincia_codigo' => '1501'],
            ['codigo' => '150109', 'nombre' => 'Cieneguilla', 'provincia_codigo' => '1501'],
            ['codigo' => '150110', 'nombre' => 'Comas', 'provincia_codigo' => '1501'],
            ['codigo' => '150111', 'nombre' => 'El Agustino', 'provincia_codigo' => '1501'],
            ['codigo' => '150112', 'nombre' => 'Independencia', 'provincia_codigo' => '1501'],
            ['codigo' => '150113', 'nombre' => 'Jesús María', 'provincia_codigo' => '1501'],
            ['codigo' => '150114', 'nombre' => 'La Molina', 'provincia_codigo' => '1501'],
            ['codigo' => '150115', 'nombre' => 'La Victoria', 'provincia_codigo' => '1501'],
            ['codigo' => '150116', 'nombre' => 'Lince', 'provincia_codigo' => '1501'],
            ['codigo' => '150117', 'nombre' => 'Los Olivos', 'provincia_codigo' => '1501'],
            ['codigo' => '150118', 'nombre' => 'Lurigancho', 'provincia_codigo' => '1501'],
            ['codigo' => '150119', 'nombre' => 'Lurín', 'provincia_codigo' => '1501'],
            ['codigo' => '150120', 'nombre' => 'Magdalena del Mar', 'provincia_codigo' => '1501'],
            ['codigo' => '150121', 'nombre' => 'Pueblo Libre', 'provincia_codigo' => '1501'],
            ['codigo' => '150122', 'nombre' => 'Miraflores', 'provincia_codigo' => '1501'],
            ['codigo' => '150123', 'nombre' => 'Pachacámac', 'provincia_codigo' => '1501'],
            ['codigo' => '150124', 'nombre' => 'Pucusana', 'provincia_codigo' => '1501'],
            ['codigo' => '150125', 'nombre' => 'Puente Piedra', 'provincia_codigo' => '1501'],
            ['codigo' => '150126', 'nombre' => 'Punta Hermosa', 'provincia_codigo' => '1501'],
            ['codigo' => '150127', 'nombre' => 'Punta Negra', 'provincia_codigo' => '1501'],
            ['codigo' => '150128', 'nombre' => 'Rímac', 'provincia_codigo' => '1501'],
            ['codigo' => '150129', 'nombre' => 'San Bartolo', 'provincia_codigo' => '1501'],
            ['codigo' => '150130', 'nombre' => 'San Borja', 'provincia_codigo' => '1501'],
            ['codigo' => '150131', 'nombre' => 'San Isidro', 'provincia_codigo' => '1501'],
            ['codigo' => '150132', 'nombre' => 'San Juan de Lurigancho', 'provincia_codigo' => '1501'],
            ['codigo' => '150133', 'nombre' => 'San Juan de Miraflores', 'provincia_codigo' => '1501'],
            ['codigo' => '150134', 'nombre' => 'San Luis', 'provincia_codigo' => '1501'],
            ['codigo' => '150135', 'nombre' => 'San Martín de Porres', 'provincia_codigo' => '1501'],
            ['codigo' => '150136', 'nombre' => 'San Miguel', 'provincia_codigo' => '1501'],
            ['codigo' => '150137', 'nombre' => 'Santa Anita', 'provincia_codigo' => '1501'],
            ['codigo' => '150138', 'nombre' => 'Santa María del Mar', 'provincia_codigo' => '1501'],
            ['codigo' => '150139', 'nombre' => 'Santa Rosa', 'provincia_codigo' => '1501'],
            ['codigo' => '150140', 'nombre' => 'Santiago de Surco', 'provincia_codigo' => '1501'],
            ['codigo' => '150141', 'nombre' => 'Surquillo', 'provincia_codigo' => '1501'],
            ['codigo' => '150142', 'nombre' => 'Villa El Salvador', 'provincia_codigo' => '1501'],
            ['codigo' => '150143', 'nombre' => 'Villa María del Triunfo', 'provincia_codigo' => '1501'],
            // Callao
            ['codigo' => '070101', 'nombre' => 'Callao', 'provincia_codigo' => '0701'],
            ['codigo' => '070102', 'nombre' => 'Bellavista', 'provincia_codigo' => '0701'],
            ['codigo' => '070103', 'nombre' => 'Carmen de La Legua Reynoso', 'provincia_codigo' => '0701'],
            ['codigo' => '070104', 'nombre' => 'La Perla', 'provincia_codigo' => '0701'],
            ['codigo' => '070105', 'nombre' => 'La Punta', 'provincia_codigo' => '0701'],
            ['codigo' => '070106', 'nombre' => 'Ventanilla', 'provincia_codigo' => '0701'],
            ['codigo' => '070107', 'nombre' => 'Mi Perú', 'provincia_codigo' => '0701'],
            // Arequipa
            ['codigo' => '040101', 'nombre' => 'Arequipa', 'provincia_codigo' => '0401'],
            ['codigo' => '040102', 'nombre' => 'Alto Selva Alegre', 'provincia_codigo' => '0401'],
            ['codigo' => '040103', 'nombre' => 'Cayma', 'provincia_codigo' => '0401'],
            ['codigo' => '040104', 'nombre' => 'Cerro Colorado', 'provincia_codigo' => '0401'],
            ['codigo' => '040105', 'nombre' => 'Characato', 'provincia_codigo' => '0401'],
            ['codigo' => '040106', 'nombre' => 'Chiguata', 'provincia_codigo' => '0401'],
            ['codigo' => '040107', 'nombre' => 'Jacobo Hunter', 'provincia_codigo' => '0401'],
            ['codigo' => '040108', 'nombre' => 'José Luis Bustamante y Rivero', 'provincia_codigo' => '0401'],
            ['codigo' => '040109', 'nombre' => 'La Joya', 'provincia_codigo' => '0401'],
            ['codigo' => '040110', 'nombre' => 'Mariano Melgar', 'provincia_codigo' => '0401'],
            ['codigo' => '040111', 'nombre' => 'Miraflores', 'provincia_codigo' => '0401'],
            ['codigo' => '040112', 'nombre' => 'Mollebaya', 'provincia_codigo' => '0401'],
            ['codigo' => '040113', 'nombre' => 'Paucarpata', 'provincia_codigo' => '0401'],
            ['codigo' => '040114', 'nombre' => 'Pocsi', 'provincia_codigo' => '0401'],
            ['codigo' => '040115', 'nombre' => 'Polobaya', 'provincia_codigo' => '0401'],
            ['codigo' => '040116', 'nombre' => 'Quequeña', 'provincia_codigo' => '0401'],
            ['codigo' => '040117', 'nombre' => 'Sabandía', 'provincia_codigo' => '0401'],
            ['codigo' => '040118', 'nombre' => 'Sachaca', 'provincia_codigo' => '0401'],
            ['codigo' => '040119', 'nombre' => 'San Juan de Siguas', 'provincia_codigo' => '0401'],
            ['codigo' => '040120', 'nombre' => 'San Juan de Tarucani', 'provincia_codigo' => '0401'],
            ['codigo' => '040121', 'nombre' => 'Santa Isabel de Siguas', 'provincia_codigo' => '0401'],
            ['codigo' => '040122', 'nombre' => 'Santa Rita de Siguas', 'provincia_codigo' => '0401'],
            ['codigo' => '040123', 'nombre' => 'Socabaya', 'provincia_codigo' => '0401'],
            ['codigo' => '040124', 'nombre' => 'Tiabaya', 'provincia_codigo' => '0401'],
            ['codigo' => '040125', 'nombre' => 'Uchumayo', 'provincia_codigo' => '0401'],
            ['codigo' => '040126', 'nombre' => 'Vitor', 'provincia_codigo' => '0401'],
            ['codigo' => '040127', 'nombre' => 'Yanahuara', 'provincia_codigo' => '0401'],
            ['codigo' => '040128', 'nombre' => 'Yarabamba', 'provincia_codigo' => '0401'],
            ['codigo' => '040129', 'nombre' => 'Yura', 'provincia_codigo' => '0401'],
            // Ica
            ['codigo' => '110101', 'nombre' => 'Ica', 'provincia_codigo' => '1101'],
            ['codigo' => '110102', 'nombre' => 'La Tinguiña', 'provincia_codigo' => '1101'],
            ['codigo' => '110103', 'nombre' => 'Los Aquijes', 'provincia_codigo' => '1101'],
            ['codigo' => '110104', 'nombre' => 'Ocucaje', 'provincia_codigo' => '1101'],
            ['codigo' => '110105', 'nombre' => 'Pachacútec', 'provincia_codigo' => '1101'],
            ['codigo' => '110106', 'nombre' => 'Parcona', 'provincia_codigo' => '1101'],
            ['codigo' => '110107', 'nombre' => 'Pueblo Nuevo', 'provincia_codigo' => '1101'],
            ['codigo' => '110108', 'nombre' => 'Salas', 'provincia_codigo' => '1101'],
            ['codigo' => '110109', 'nombre' => 'San José de Los Molinos', 'provincia_codigo' => '1101'],
            ['codigo' => '110110', 'nombre' => 'San Juan Bautista', 'provincia_codigo' => '1101'],
            ['codigo' => '110111', 'nombre' => 'Santiago', 'provincia_codigo' => '1101'],
            ['codigo' => '110112', 'nombre' => 'Subtanjalla', 'provincia_codigo' => '1101'],
            ['codigo' => '110113', 'nombre' => 'Tate', 'provincia_codigo' => '1101'],
            ['codigo' => '110114', 'nombre' => 'Yauca del Rosario', 'provincia_codigo' => '1101'],
            // Trujillo
            ['codigo' => '130101', 'nombre' => 'Trujillo', 'provincia_codigo' => '1301'],
            ['codigo' => '130102', 'nombre' => 'El Porvenir', 'provincia_codigo' => '1301'],
            ['codigo' => '130103', 'nombre' => 'Florencia de Mora', 'provincia_codigo' => '1301'],
            ['codigo' => '130104', 'nombre' => 'Huanchaco', 'provincia_codigo' => '1301'],
            ['codigo' => '130105', 'nombre' => 'La Esperanza', 'provincia_codigo' => '1301'],
            ['codigo' => '130106', 'nombre' => 'Laredo', 'provincia_codigo' => '1301'],
            ['codigo' => '130107', 'nombre' => 'Moche', 'provincia_codigo' => '1301'],
            ['codigo' => '130108', 'nombre' => 'Poroto', 'provincia_codigo' => '1301'],
            ['codigo' => '130109', 'nombre' => 'Salaverry', 'provincia_codigo' => '1301'],
            ['codigo' => '130110', 'nombre' => 'Simbal', 'provincia_codigo' => '1301'],
            ['codigo' => '130111', 'nombre' => 'Victor Larco Herrera', 'provincia_codigo' => '1301'],
            // Chiclayo
            ['codigo' => '140101', 'nombre' => 'Chiclayo', 'provincia_codigo' => '1401'],
            ['codigo' => '140102', 'nombre' => 'Chongoyape', 'provincia_codigo' => '1401'],
            ['codigo' => '140103', 'nombre' => 'Eten', 'provincia_codigo' => '1401'],
            ['codigo' => '140104', 'nombre' => 'Eten Puerto', 'provincia_codigo' => '1401'],
            ['codigo' => '140105', 'nombre' => 'José Leonardo Ortiz', 'provincia_codigo' => '1401'],
            ['codigo' => '140106', 'nombre' => 'La Victoria', 'provincia_codigo' => '1401'],
            ['codigo' => '140107', 'nombre' => 'Lagunas', 'provincia_codigo' => '1401'],
            ['codigo' => '140108', 'nombre' => 'Monsefú', 'provincia_codigo' => '1401'],
            ['codigo' => '140109', 'nombre' => 'Nueva Arica', 'provincia_codigo' => '1401'],
            ['codigo' => '140110', 'nombre' => 'Oyotún', 'provincia_codigo' => '1401'],
            ['codigo' => '140111', 'nombre' => 'Picsi', 'provincia_codigo' => '1401'],
            ['codigo' => '140112', 'nombre' => 'Pimentel', 'provincia_codigo' => '1401'],
            ['codigo' => '140113', 'nombre' => 'Reque', 'provincia_codigo' => '1401'],
            ['codigo' => '140114', 'nombre' => 'Santa Rosa', 'provincia_codigo' => '1401'],
            ['codigo' => '140115', 'nombre' => 'Saña', 'provincia_codigo' => '1401'],
            ['codigo' => '140116', 'nombre' => 'Cayaltí', 'provincia_codigo' => '1401'],
            ['codigo' => '140117', 'nombre' => 'Pátapo', 'provincia_codigo' => '1401'],
            ['codigo' => '140118', 'nombre' => 'Pomalca', 'provincia_codigo' => '1401'],
            ['codigo' => '140119', 'nombre' => 'Pucalá', 'provincia_codigo' => '1401'],
            ['codigo' => '140120', 'nombre' => 'Tumán', 'provincia_codigo' => '1401'],
            // Piura
            ['codigo' => '200101', 'nombre' => 'Piura', 'provincia_codigo' => '2001'],
            ['codigo' => '200102', 'nombre' => 'Castilla', 'provincia_codigo' => '2001'],
            ['codigo' => '200103', 'nombre' => 'Catacaos', 'provincia_codigo' => '2001'],
            ['codigo' => '200104', 'nombre' => 'Cura Mori', 'provincia_codigo' => '2001'],
            ['codigo' => '200105', 'nombre' => 'El Tallán', 'provincia_codigo' => '2001'],
            ['codigo' => '200106', 'nombre' => 'La Arena', 'provincia_codigo' => '2001'],
            ['codigo' => '200107', 'nombre' => 'La Unión', 'provincia_codigo' => '2001'],
            ['codigo' => '200108', 'nombre' => 'Las Lomas', 'provincia_codigo' => '2001'],
            ['codigo' => '200109', 'nombre' => 'Tambo Grande', 'provincia_codigo' => '2001'],
            ['codigo' => '200110', 'nombre' => 'Veintiséis de Octubre', 'provincia_codigo' => '2001'],
        ];

        foreach ($distritosLima as $dist) {
            $provId = DB::table('provincias')->where('codigo', $dist['provincia_codigo'])->value('id');
            $deptoId = DB::table('provincias')->where('codigo', $dist['provincia_codigo'])->value('departamento_id');
            
            if ($provId && $deptoId) {
                DB::table('distritos')->insert([
                    'codigo' => $dist['codigo'],
                    'nombre' => $dist['nombre'],
                    'slug' => Str::slug($dist['nombre']),
                    'provincia_id' => $provId,
                    'departamento_id' => $deptoId,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
