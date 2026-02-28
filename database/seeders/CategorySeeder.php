<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Loyer', 'color' => '#78350f', 'is_default' => true],
            ['name' => 'Électricité', 'color' => '#b45309', 'is_default' => true],
            ['name' => 'Eau', 'color' => '#0f766e', 'is_default' => true],
            ['name' => 'Internet', 'color' => '#1e40af', 'is_default' => true],
            ['name' => 'Courses', 'color' => '#166534', 'is_default' => true],
            ['name' => 'Sorties', 'color' => '#86198f', 'is_default' => true],
            ['name' => 'Épargne', 'color' => '#854d0e', 'is_default' => true],
            ['name' => 'Divers', 'color' => '#4b5563', 'is_default' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}