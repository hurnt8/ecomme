<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * The template ships nine distinct product photos plus five angles of a single piece (the
 * concrete rocking chair: product-single-1..5). Earlier revisions spread those five across
 * unrelated products so every item had a second image, which put a rocking chair in the
 * speaker's gallery. They now stay with the piece they actually show, and every other product
 * keeps only its own photo — descriptions, colours and categories are written to match what is
 * visible in each image rather than the generic copy that shipped before.
 */
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
                'description' => "Fauteuil à bascule à coque en béton poli, monté sur un châssis en acier torsadé et des patins en bouleau contreplaqué. Le béton, coulé en faible épaisseur, garde une surface douce et légèrement nuancée : chaque coque est unique. Une assise de caractère, à l'aise au salon comme sous une véranda.\n\nDimensions : 68 x 90 x 95 cm. Coque en béton fibré, châssis acier, patins en contreplaqué de bouleau, finition mate.",
                'price' => 350,
                'compare_at_price' => null,
                'colors' => ['Béton brut', 'Béton anthracite'],
                'stock' => 12,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => [
                    'product-1.jpg',
                    'product-single-2.jpg',
                    'product-single-1.jpg',
                    'product-single-5.jpg',
                    'product-single-3.jpg',
                    'product-single-4.jpg',
                ],
            ],
            [
                'category_id' => $equipement->id,
                'name' => 'Pavilion Speaker',
                'description' => "Enceinte cylindrique à socle béton et corps laqué, ponctuée d'un anneau cuivré qui laisse deviner le haut-parleur. Le socle minéral fait contrepoids et amortit les vibrations ; l'ensemble se pose aussi bien sur une étagère que sur un plan de travail.\n\nDimensions : 12 x 12 x 30 cm. Socle en béton, corps laqué mat, détails cuivre, connexion sans fil, autonomie 10 heures.",
                'price' => 600,
                'compare_at_price' => 680,
                'colors' => ['Blanc', 'Noir'],
                'stock' => 6,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => ['product-2.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Ligomancer',
                'description' => "Banquette basse à structure tubulaire cuivrée, garnie de sangles de cuir tressées à la main. Le tressage, tendu directement sur le cadre, forme une assise souple qui épouse le corps sans mousse ni ressort.\n\nDimensions : 160 x 80 x 60 cm. Structure en tube d'acier cuivré, sangles de cuir pleine fleur tressées main.",
                'price' => 780,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 3,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => ['product-3.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Alato Cabinet',
                'description' => "Buffet deux portes en frêne clair, dont la façade est composée d'écailles de bois superposées teintées en dégradé, du bois naturel au bleu ardoise. Chaque écaille est découpée et posée à la main : la façade se lit différemment selon l'angle et la lumière.\n\nDimensions : 140 x 45 x 85 cm. Frêne massif et contreplaqué de frêne teinté, piétement acier laqué noir, étagère intérieure réglable.",
                'price' => 800,
                'compare_at_price' => null,
                'colors' => ['Dégradé bleu', 'Frêne naturel'],
                'stock' => 8,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => ['product-4.jpg'],
            ],
            [
                'category_id' => $equipement->id,
                'name' => 'Earing Wireless',
                'description' => "Écouteurs sans fil au corps strié, usinés dans un bloc d'aluminium anodisé et finis d'une grille laiton. Les stries ne sont pas qu'un motif : elles servent de prise en main pour insérer et retirer l'écouteur d'un seul geste.\n\nDimensions : 22 x 22 x 30 mm par écouteur. Aluminium anodisé, grille laiton, embouts silicone (3 tailles), autonomie 6 heures, boîtier de charge inclus.",
                'price' => 100,
                'compare_at_price' => 120,
                'colors' => ['Noir mat'],
                'stock' => 20,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => ['product-5.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Sculptural Coffee Table',
                'description' => "Table basse composée d'un plateau de marbre blanc posé en porte-à-faux sur un rondin de bois brut laissé dans sa forme d'origine. Le contraste est volontaire : la pierre polie et rectiligne d'un côté, le tronc écorcé et irrégulier de l'autre.\n\nDimensions : 120 x 60 x 35 cm. Plateau en marbre de Carrare, base en tronc de peuplier massif, finition huile incolore. Pièce unique : le rondin varie d'un exemplaire à l'autre.",
                'price' => 960,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 4,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => ['product-6.jpg'],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'The WW Chair',
                'description' => "Chaise à dossier fuselé, dans la lignée des assises Windsor : une série de fins barreaux verticaux vient se ficher dans une traverse cintrée, au-dessus d'une assise pleine sculptée en creux. Piétement tripode fuselé, léger à déplacer.\n\nDimensions : 52 x 50 x 78 cm. Frêne massif, assise sculptée, barreaux en acier laqué, finition huile ou laque mate selon coloris.",
                'price' => 540,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Noir'],
                'stock' => 15,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => ['product-7.jpg'],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Himitsu Money Box',
                'description' => "Tirelire cylindrique tournée dans un bloc de métal plein, fendue d'une seule ouverture pour les pièces. Il n'y a pas de bouchon : la boîte se garde fermée jusqu'à ce qu'on décide de l'ouvrir, comme les tirelires en terre d'autrefois.\n\nDimensions : 8 x 8 x 11 cm. Laiton, cuivre ou acier nickelé massif, finition polie.",
                'price' => 55,
                'compare_at_price' => null,
                'colors' => ['Cuivre', 'Laiton', 'Nickel'],
                'stock' => 30,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => ['product-8.jpg'],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Ariane Prin',
                'description' => "Cache-pot tourné à la main, dont l'émail se dépose en bandes horizontales terre, sable et ocre, comme des strates géologiques. La cuisson au bois laisse des variations de teinte que le tourneur ne maîtrise qu'en partie : deux pièces ne sont jamais identiques.\n\nDimensions : 20 x 20 x 22 cm. Grès tourné main, émail mat, cuisson au bois. Percé au fond, soucoupe non fournie.",
                'price' => 99,
                'compare_at_price' => null,
                'colors' => ['Terre', 'Sable', 'Ocre'],
                'stock' => 18,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => ['product-9.jpg'],
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
