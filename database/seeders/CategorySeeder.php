<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Chaises & Fauteuils', 'slug' => 'chaises-fauteuils', 'description' => 'Assises pour le salon, la salle à manger ou le bureau.', 'sort_order' => 0],
            ['name' => 'Tables', 'slug' => 'tables', 'description' => 'Tables basses, tables à manger et bureaux.', 'sort_order' => 1],
            ['name' => 'Rangement', 'slug' => 'rangement', 'description' => 'Buffets, armoires et meubles de rangement.', 'sort_order' => 2],
            ['name' => 'Décoration', 'slug' => 'decoration', 'description' => 'Objets et accessoires pour sublimer votre intérieur.', 'sort_order' => 3],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
        }
    }
}
