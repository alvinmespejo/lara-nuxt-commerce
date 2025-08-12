<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => $name = fake()->words(3, true),
                'slug' => \Illuminate\Support\Str::slug($name)
            ],
            [
                'name' => $name = fake()->words(3, true),
                'slug' => \Illuminate\Support\Str::slug($name)
            ],
            [
                'name' => $name = fake()->words(3, true),
                'slug' => \Illuminate\Support\Str::slug($name)
            ],
            [
                'name' => $name = fake()->words(3, true),
                'slug' => \Illuminate\Support\Str::slug($name)
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['slug' => $category['slug']],
            );
            // Log::debug('category', $category);
        }
    }
}
