<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tronçonneuses & Élagage', 'slug' => 'tronconneuses-elagage', 'description' => 'Tronçonneuses, élagueuses et perches télescopiques pour couper en hauteur sans échelle, du verger à la coupe de bois de chauffage.', 'sort_order' => 0],
            ['name' => 'Tracteurs tondeuses & Autoportées', 'slug' => 'tracteurs-autoportees', 'description' => 'Autoportées à éjection arrière, latérale ou avec bac, pour les terrains que l\'on ne tond plus raisonnablement à pied.', 'sort_order' => 1],
            ['name' => 'Outils pour tracteur', 'slug' => 'outils-tracteur', 'description' => 'Broyeurs à marteaux, bennes, fourches, charrues et remorques à atteler en trois points, choisis pour la puissance de tracteur que vous avez déjà.', 'sort_order' => 2],
            ['name' => 'Tondeuses', 'slug' => 'tondeuses', 'description' => 'Tondeuses thermiques et à batterie, poussées ou tractées, du petit jardin de ville au terrain de plusieurs milliers de mètres carrés.', 'sort_order' => 3],
            ['name' => 'Robots tondeuses', 'slug' => 'robots-tondeuses', 'description' => 'Robots avec fil périphérique ou sans installation, pour que la tonte cesse d\'être une tâche — du jardin de ville au parc de plusieurs hectares.', 'sort_order' => 4],
            ['name' => 'Débroussailleuses & Motoculture', 'slug' => 'motoculture', 'description' => 'Débroussailleuses, motobineuses et motoculteurs pour reprendre une friche, préparer un potager ou entretenir un terrain en pente.', 'sort_order' => 5],
            ['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'description' => 'Bûches, granulés et poêles livrés chez vous — le prolongement naturel d\'une saison passée à couper et à débroussailler.', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
        }

        // Ranges from the furniture catalogue this shop used to sell, plus 'tondeuses-robots':
        // robots outgrew their half of that shared range and now have one of their own, so the
        // combined slug is retired rather than renamed. nullOnDelete on products.category_id
        // means dropping these is safe even before ProductSeeder re-points every product.
        Category::query()->whereIn('slug', [
            'tondeuses-robots',
            'mobilier',
            'jardin-exterieur',
            'decoration',
            'salle-de-bain',
            'equipement-maison',
            'chaises-fauteuils',
            'tables',
            'rangement',
        ])->delete();
    }
}
