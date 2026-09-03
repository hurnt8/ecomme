<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $mobilier = Category::where('slug', 'mobilier')->firstOrFail();
        $jardin = Category::where('slug', 'jardin-exterieur')->firstOrFail();
        $deco = Category::where('slug', 'decoration')->firstOrFail();
        $equipement = Category::where('slug', 'equipement-maison')->firstOrFail();

        $products = [
            [
                'category_id' => $jardin->id,
                'name' => 'Hauteville Concrete Rocking Chair',
                'description' => "Ce fauteuil à bascule associe une coque en béton poli, légère et résistante, à des piétements en frêne massif huilé. Son galbe enveloppant et son assise généreuse en font une pièce de caractère, aussi confortable pour lire au salon que pour bercer sur la terrasse.\n\nDimensions : 68 x 90 x 95 cm. Coque en béton fibré, structure en frêne massif, finition huile naturelle.",
                'price' => 350,
                'compare_at_price' => null,
                'colors' => ['Béton brut', 'Béton anthracite'],
                'stock' => 12,
                'is_new' => true,
                'images' => ['product-1.jpg', 'product-single-1.jpg'],
            ],
            [
                'category_id' => $equipement->id,
                'name' => 'Pavilion Speaker',
                'description' => "Enceinte acoustique habillée de chêne massif et de tissu acoustique tramé, pensée pour se fondre dans un intérieur plutôt que s'y imposer. Le caisson en bois plein offre un rendu sonore chaud, sans câblage apparent grâce à la connexion sans fil.\n\nDimensions : 25 x 20 x 35 cm. Caisson en chêne massif, façade en tissu acoustique tramé, autonomie 10 heures.",
                'price' => 600,
                'compare_at_price' => 680,
                'colors' => null,
                'stock' => 6,
                'is_new' => false,
                'images' => ['product-2.jpg', 'product-single-2.jpg'],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Ligomancer',
                'description' => "Sculpture décorative en chêne massif sculpté à la main, pièce unique par nature : le veinage du bois dessine des motifs qui varient d'un exemplaire à l'autre. À poser sur une console ou une étagère pour un point focal minéral et organique.\n\nDimensions : 35 x 20 x 45 cm. Chêne massif sculpté, finition huile naturelle.",
                'price' => 780,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 3,
                'is_new' => false,
                'images' => ['product-3.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Alato Cabinet',
                'description' => "Buffet bas en noyer massif à trois portes, plaquage veiné assorti et poignées laiton brossé. Étagères intérieures réglables pour organiser vaisselle, linge de maison ou rangements de salon.\n\nDimensions : 160 x 45 x 75 cm. Noyer massif, poignées laiton brossé, étagères réglables.",
                'price' => 800,
                'compare_at_price' => null,
                'colors' => ['Noyer', 'Chêne fumé'],
                'stock' => 8,
                'is_new' => false,
                'images' => ['product-4.jpg', 'product-single-3.jpg'],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Earing Wireless',
                'description' => "Lampe baladeuse sans fil au design épuré, corps en aluminium brossé et base lestée. Autonomie de 12 heures, idéale pour éclairer une table basse ou un coin lecture sans contrainte de prise.\n\nDimensions : 10 x 10 x 24 cm. Aluminium brossé, base lestée, recharge USB-C.",
                'price' => 100,
                'compare_at_price' => 120,
                'colors' => ['Laiton', 'Noir mat'],
                'stock' => 20,
                'is_new' => true,
                'images' => ['product-5.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Sculptural Coffee Table',
                'description' => "Table basse sculpturale au plateau en marbre veiné reposant sur un piétement en bois massif cintré. Une pièce statement pour un salon contemporain, où la table devient elle-même un objet de décoration.\n\nDimensions : 120 x 60 x 35 cm. Plateau marbre veiné, piétement bois massif cintré.",
                'price' => 960,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 4,
                'is_new' => false,
                'images' => ['product-6.jpg', 'product-single-4.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'The WW Chair',
                'description' => "Chaise au piétement bois cintré et à l'assise coque moulée, hommage aux lignes scandinaves des années 50. Empilable, elle s'installe aussi bien en salle à manger qu'en poste de bureau.\n\nDimensions : 52 x 55 x 80 cm. Piétement hêtre massif cintré, assise coque moulée.",
                'price' => 540,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Noir'],
                'stock' => 15,
                'is_new' => false,
                'images' => ['product-7.jpg'],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Himitsu Money Box',
                'description' => "Boîte à secrets en bois marqueté, mécanisme d'ouverture dissimulé façon puzzle japonais. Un objet ludique et décoratif pour ranger petits trésors et bijoux.\n\nDimensions : 12 x 9 x 6 cm. Marqueterie de bois, mécanisme à tiroirs coulissants.",
                'price' => 55,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 30,
                'is_new' => false,
                'images' => ['product-8.jpg'],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Ariane Prin',
                'description' => "Vase en céramique tourné à la main, glaçure mate irrégulière qui capte la lumière. Chaque pièce est unique et légèrement différente de la photo, signature du travail artisanal.\n\nDimensions : 18 x 18 x 22 cm. Céramique tournée et émaillée à la main.",
                'price' => 99,
                'compare_at_price' => null,
                'colors' => ['Sable', 'Terracotta', 'Vert sauge'],
                'stock' => 18,
                'is_new' => true,
                'images' => ['product-9.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'The Haluz Rocking Chair',
                'description' => "Rocking-chair en bois cintré et cannage tressé main, silhouette légère et aérienne. Un classique revisité pour un coin lecture chaleureux.\n\nDimensions : 65 x 95 x 90 cm. Bois cintré, cannage tressé main, finition vernis naturel.",
                'price' => 420,
                'compare_at_price' => null,
                'colors' => ['Naturel', 'Noyer'],
                'stock' => 10,
                'is_new' => true,
                'images' => ['product-single-5.jpg'],
            ],
        ];

        foreach ($products as $data) {
            $images = $data['images'];
            unset($data['images']);

            $product = Product::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                $data + ['slug' => Str::slug($data['name']), 'is_active' => true]
            );

            $product->images()->delete();

            foreach ($images as $position => $file) {
                $path = 'products/'.$file;

                if (! Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put(
                        $path,
                        file_get_contents(__DIR__.'/assets/products/'.$file)
                    );
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'position' => $position,
                ]);
            }
        }
    }
}
