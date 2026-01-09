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
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Diseño";
        $category->slug = Str::slug($category->name);
        $category->estado = "Activo";
        $category->save();

        $category = new Category();
        $category->name = "Ingeniería";
        $category->slug = Str::slug($category->name);
        $category->estado = "Activo";
        $category->save();
    }
}
