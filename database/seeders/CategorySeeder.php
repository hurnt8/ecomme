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
            ['name' => 'Outils pour tracteur', 'slug' => 'outils-tracteur', 'description' => 'Broyeurs, bennes, fourches et charrues à atteler en trois points, choisis pour la puissance de tracteur que vous avez déjà.', 'sort_order' => 2],
            ['name' => 'Tondeuses & Robots', 'slug' => 'tondeuses-robots', 'description' => 'Tondeuses thermiques, à batterie et robots de tonte, du petit jardin de ville au terrain de plusieurs milliers de mètres carrés.', 'sort_order' => 3],
            ['name' => 'Débroussailleuses & Motoculture', 'slug' => 'motoculture', 'description' => 'Débroussailleuses, motobineuses et motoculteurs pour reprendre une friche, préparer un potager ou entretenir un terrain en pente.', 'sort_order' => 4],
            ['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'description' => 'Bûches, granulés et poêles livrés chez vous — le prolongement naturel d\'une saison passée à couper et à débroussailler.', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
        }

        // Ranges from the furniture catalogue this shop used to sell. Bois & Chauffage is the one
        // that survives the change of trade, so its slug is deliberately reused above rather than
        // recreated. nullOnDelete on products.category_id means dropping the rest is safe even
        // before ProductSeeder replaces every product.
        Category::query()->whereIn('slug', [
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
