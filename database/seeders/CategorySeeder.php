<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Mobilier', 'slug' => 'mobilier', 'description' => 'Chaises, tables et rangements en matières durables pour meubler chaque pièce.', 'sort_order' => 0],
            ['name' => 'Jardin & Extérieur', 'slug' => 'jardin-exterieur', 'description' => 'Mobilier et accessoires pensés pour résister aux saisons, sur la terrasse comme au jardin.', 'sort_order' => 1],
            ['name' => 'Décoration', 'slug' => 'decoration', 'description' => 'Objets et accessoires pour sublimer votre intérieur.', 'sort_order' => 2],
            ['name' => 'Salle de bain', 'slug' => 'salle-de-bain', 'description' => 'Meubles sous-vasque, miroirs et vasques en teck massif et pierre naturelle, choisis pour tenir dans une pièce humide.', 'sort_order' => 3],
            ['name' => 'Équipement Maison', 'slug' => 'equipement-maison', 'description' => 'Petit électroménager et objets utiles au quotidien, choisis pour durer.', 'sort_order' => 4],
            ['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'description' => 'Bois de chauffage et accessoires pour cheminée et poêle, livrés chez vous.', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
        }

        // Replaced by the five categories above (the catalog no longer subdivides furniture
        // by piece type). nullOnDelete on products.category_id means this is safe even before
        // ProductSeeder re-points every product at its new category.
        Category::query()->whereIn('slug', ['chaises-fauteuils', 'tables', 'rangement'])->delete();
    }
}
