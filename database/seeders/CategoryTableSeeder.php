<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->name = "Desarrollo de software";
        $category->slug = Str::slug($category->name);
        $category->imagen = "desarrollo de software.png";
        $category->icono = "bi bi-code-slash";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Diseño";
        $category->slug = Str::slug($category->name);
        $category->imagen = "diseño.png";
        $category->icono = "bi bi-bezier";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Ingeniería";
        $category->slug = Str::slug($category->name);
        $category->imagen = "ingenieria.png";
        $category->icono = "bi bi-lightbulb";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Hardware";
        $category->slug = Str::slug($category->name);
        $category->imagen = "hardware.png";
        $category->icono = "bi bi-motherboard";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Marketing";
        $category->slug = Str::slug($category->name);
        $category->imagen = "marketing.png";
        $category->icono = "bi bi-bar-chart-line";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Desarrollo personal";
        $category->slug = Str::slug($category->name);
        $category->imagen = "desarrollo personal.png";
        $category->icono = "bi bi-person-arms-up";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Fotografía y video";
        $category->slug = Str::slug($category->name);
        $category->imagen = "fotografia.png";
        $category->icono = "bi bi-camera-reels";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Música";
        $category->slug = Str::slug($category->name);
        $category->imagen = "musica.png";
        $category->icono = "bi bi-music-note-beamed";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Idiomas";
        $category->slug = Str::slug($category->name);
        $category->imagen = "idiomas.png";
        $category->icono = "bi bi-translate";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Negocios";
        $category->slug = Str::slug($category->name);
        $category->imagen = "negocios.png";
        $category->icono = "bi bi-suitcase-lg";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Humanidades";
        $category->slug = Str::slug($category->name);
        $category->imagen = "humanidades.png";
        $category->icono = "bi bi-puzzle";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Salud";
        $category->slug = Str::slug($category->name);
        $category->imagen = "salud.png";
        $category->icono = "bi bi-bandaid";
        $category->tipo = "CURSO";
        $category->estado = "Activo";
        $category->save();
    }
}
