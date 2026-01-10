<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BancoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banco = new Banco();
        $banco->name = "Banco de crédito del Perú - BCP";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "bcp-logo.jpg";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Banco Interamericano de Finanzas - BanBif";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "banbif.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Banco Pichincha";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "pichincha.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Banco Continental - BBVA";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "bbva.jpg";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Interbank";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "interbank-logo.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Mibanco";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "mi_banco.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Scotiabank Perú";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "scotiabank-logo.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Banco de la Nación";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "banco_nacion.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Banco GNB Perú";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "banco_gnb.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Banco Falabella";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "Activo";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Arequipa";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "caja_arequipa.jpg";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Cusco";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "caja_cusco.png";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Trujillo";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "Activo";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Huancayo";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "caja_huancay.jpg";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Ica";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "Activo";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Piura";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "caja_piura.jpg";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Sullana";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "caja_sullana.jpg";
        $banco->save();

        $banco = new Banco();
        $banco->name = "Caja Tacna";
        $banco->slug = Str::slug($banco->name);
        $banco->estado = "Activo";
        $banco->imagen = "Activo";
        $banco->save();
    }
}
