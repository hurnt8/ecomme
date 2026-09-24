<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // The slugs here are the ones data/catalogue.json resolves every imported product to;
        // ProductSeeder throws rather than seeding if a range named there is missing from this
        // list, so the two files cannot drift apart silently.
        $categories = [
            ['name' => 'Tondeuses', 'slug' => 'tondeuses', 'description' => 'Tondeuses thermiques, électriques et à batterie, poussées ou tractées, du petit jardin de ville au terrain de plusieurs milliers de mètres carrés.', 'sort_order' => 8],
            ['name' => 'Robots tondeuses', 'slug' => 'robots-tondeuses', 'description' => 'Robots avec fil périphérique ou sans installation, pour que la tonte cesse d\'être une tâche — du jardin de ville au parc de plusieurs hectares.', 'sort_order' => 9],
            ['name' => 'Tracteurs tondeuses & Autoportées', 'slug' => 'tracteurs-autoportees', 'description' => 'Autoportées à éjection arrière, latérale ou avec bac, pour les terrains que l\'on ne tond plus raisonnablement à pied.', 'sort_order' => 10],
            ['name' => 'Tronçonneuses & Élagage', 'slug' => 'tronconneuses-elagage', 'description' => 'Tronçonneuses, élagueuses et perches télescopiques pour couper en hauteur sans échelle, du verger à la coupe de bois de chauffage.', 'sort_order' => 2],
            ['name' => 'Débroussailleuses & Motoculture', 'slug' => 'motoculture', 'description' => 'Débroussailleuses, motobineuses, motoculteurs et sécateurs pour reprendre une friche, préparer un potager ou entretenir un terrain en pente.', 'sort_order' => 4],
            ['name' => 'Taille-haies & Souffleurs', 'slug' => 'taille-haies-souffleurs', 'description' => 'Taille-haies, souffleurs, aspirateurs à feuilles, scarificateurs et fraises à neige : l\'entretien qui suit les saisons.', 'sort_order' => 5],
            ['name' => 'Outils pour tracteur', 'slug' => 'outils-tracteur', 'description' => 'Broyeurs à marteaux, bennes, fourches, charrues, herses et remorques à atteler en trois points, choisis pour la puissance de tracteur que vous avez déjà.', 'sort_order' => 3],
            ['name' => 'Pompes & Pulvérisation', 'slug' => 'pompes-pulverisation', 'description' => 'Motopompes d\'irrigation, électropompes, pompes immergées, nettoyeurs haute pression et pulvérisateurs.', 'sort_order' => 7],
            ['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'description' => 'Bûches, granulés, briquettes et poêles livrés chez vous — le prolongement naturel d\'une saison passée à couper et à débroussailler.', 'sort_order' => 0],
            ['name' => 'Barbecues & Fours d\'extérieur', 'slug' => 'barbecues-fours', 'description' => 'Barbecues et fours à pizza pour l\'extérieur comme pour la cuisine, à bois, à charbon ou à gaz.', 'sort_order' => 1],
            ['name' => 'Piscines & Spas', 'slug' => 'piscines', 'description' => 'Piscines gonflables, tubulaires, hors sol et en bois, avec les robots nettoyeurs et les accessoires qui vont avec.', 'sort_order' => 11],
            ['name' => 'Jardin & Extérieur', 'slug' => 'jardin-exterieur', 'description' => 'Abris de jardin, accessoires et pièces détachées : ce qui complète le reste du catalogue.', 'sort_order' => 6],
        ];

        // Tile artwork for the home page's "Acheter par catégorie" carousel, from the matching ranges
        // on guerrinibois.fr. Only written when the category has no image yet, so one uploaded from
        // the back office survives a reseed; the others fall back to a product photo.
        $images = [
            'bois-chauffage' => 'categories/bois-chauffage.jpg',
            'jardin-exterieur' => 'categories/jardin-exterieur.jpg',
        ];

        foreach ($categories as $category) {
            $model = Category::query()->updateOrCreate(['slug' => $category['slug']], $category + ['is_active' => true]);
            $image = $images[$category['slug']] ?? null;

            if ($image && ! $model->image) {
                Storage::disk('public')->put($image, file_get_contents(__DIR__.'/assets/'.$image));
                $model->update(['image' => $image]);
            }
        }

        // Ranges retired along the way: the furniture catalogue this shop sold before the change
        // of trade, and 'tondeuses-robots', whose two halves each outgrew the shared range.
        // nullOnDelete on products.category_id means dropping these is safe even before
        // ProductSeeder re-points every product.
        Category::query()->whereIn('slug', [
            'tondeuses-robots',
            'mobilier',
            'decoration',
            'salle-de-bain',
            'equipement-maison',
            'chaises-fauteuils',
            'tables',
            'rangement',
        ])->delete();
    }
}
