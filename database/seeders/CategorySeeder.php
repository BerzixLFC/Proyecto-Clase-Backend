<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $tecnologia = new Category();
        $tecnologia->name = "Tecnología";
        $tecnologia->description = "Productos relacionados con la tecnología, como computadoras, teléfonos, etc.";
        $tecnologia->save();
    }
}
