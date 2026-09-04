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
        $bois = Category::where('slug', 'bois-chauffage')->firstOrFail();

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

            /*
             * The catalogue proper: solid-wood furniture by room, plus the firewood line. The
             * template only ships nine photographs, all spoken for above, so these carry no
             * image and fall back to Product's neutral placeholder until real photography is
             * uploaded through the back office — never to another product's picture.
             */

            // ---- Salle à manger ----
            [
                'category_id' => $mobilier->id,
                'name' => 'Table à manger Grand Chêne 200 cm',
                'description' => "Table de salle à manger en chêne massif, plateau d'une seule épaisseur aux chants adoucis, posé sur un piétement en acier laqué noir en X. Le chêne est huilé, non verni : une rayure se ponce et se reprend localement.\n\nDimensions : 200 x 100 x 76 cm. Plateau chêne massif 4 cm, piétement acier laqué noir, finition huile naturelle. Convient à 8 convives. Livrée avec plateau et piétement séparés, montage 20 minutes à deux.",
                'price' => 1290,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 4,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Table à manger Acacia Live Edge 180 cm',
                'description' => "Table en acacia massif dont les deux longs chants sont laissés bruts, suivant la forme de la grume. Chaque plateau est donc unique et la largeur varie de quelques centimètres d'une table à l'autre.\n\nDimensions : 180 x 90 (±4) x 76 cm. Acacia massif 4 cm, chants naturels, piétement acier trapèze. Convient à 6 convives.",
                'price' => 990,
                'compare_at_price' => 1190,
                'colors' => null,
                'stock' => 3,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Banc de table Chêne 180 cm',
                'description' => "Banc en chêne massif assorti à la table Grand Chêne, piétement acier en X. Se glisse entièrement sous le plateau lorsqu'il n'est pas utilisé.\n\nDimensions : 180 x 35 x 45 cm. Chêne massif, piétement acier laqué noir, finition huile naturelle. Supporte 3 personnes.",
                'price' => 490,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 6,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Chaise Acacia assise tissu',
                'description' => "Chaise à structure en acacia massif et assise garnie, habillée d'un tissu gris clair au tissage serré. Dossier légèrement incliné, pensé pour rester à table après le repas.\n\nDimensions : 46 x 55 x 82 cm, hauteur d'assise 46 cm. Acacia massif, mousse haute résilience, tissu 100 % polyester (40 000 tours Martindale). Housse non déhoussable.",
                'price' => 249,
                'compare_at_price' => null,
                'colors' => ['Gris clair', 'Anthracite'],
                'sizes' => null,
                'stock' => 24,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => [],
            ],

            // ---- Salon ----
            [
                'category_id' => $mobilier->id,
                'name' => 'Table basse Racine de teck 60 cm',
                'description' => "Table basse taillée dans une souche de teck recyclée, poncée et vernie mate. Les nœuds, les fentes et les creux du bois sont conservés : deux pièces ne se ressemblent jamais et les dimensions varient légèrement.\n\nDimensions : environ 60 x 60 x 40 cm. Racine de teck massive, finition vernis mat. Pièce unique, poids 18 à 25 kg selon la souche.",
                'price' => 320,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 5,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Table basse Chêne pieds X 110 cm',
                'description' => "Table basse en chêne massif au plateau épais, portée par un piétement acier en X qui la fait paraître plus légère qu'elle ne l'est.\n\nDimensions : 110 x 60 x 40 cm. Chêne massif 4 cm, piétement acier laqué noir, finition huile naturelle.",
                'price' => 490,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 7,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Meuble TV suspendu Acacia 160 cm',
                'description' => "Meuble TV mural en acacia massif, trois tiroirs à ouverture par poussée, sans poignée apparente. Fixation murale invisible : l'espace sous le meuble reste libre pour le passage de l'aspirateur et des câbles.\n\nDimensions : 160 x 40 x 30 cm. Acacia massif, tiroirs sur coulisses à fermeture douce, passe-câbles à l'arrière. Fixations murales fournies (chevilles pour mur plein).",
                'price' => 690,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 5,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Bibliothèque Acacia 100 cm',
                'description' => "Bibliothèque en acacia massif à cases décalées, montée sans vis apparente. Assez profonde pour des livres grand format posés à plat.\n\nDimensions : 100 x 35 x 180 cm. Acacia massif, six cases, finition huile naturelle. Système anti-bascule fourni.",
                'price' => 690,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 4,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ---- Chambre ----
            [
                'category_id' => $mobilier->id,
                'name' => 'Lit Chêne et métal 180 x 200',
                'description' => "Lit double à structure en chêne massif et traverses métal, tête de lit pleine aux montants adoucis. Le sommier à lattes se pose directement sur le cadre, sans pieds centraux visibles.\n\nDimensions : 196 x 216 x 90 cm (couchage 180 x 200). Chêne massif et acier laqué noir, hauteur sous cadre 25 cm. Sommier et matelas non fournis.",
                'price' => 1190,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 3,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Chevet Chêne et métal 40 cm',
                'description' => "Chevet compact en chêne massif, un tiroir et une niche ouverte, piétement métal. Assorti au lit Chêne et métal.\n\nDimensions : 40 x 35 x 50 cm. Chêne massif, tiroir sur coulisses à fermeture douce, piétement acier laqué noir.",
                'price' => 190,
                'compare_at_price' => 225,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 12,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ---- Entrée ----
            [
                'category_id' => $mobilier->id,
                'name' => 'Banc d\'entrée Branches de teck 100 cm',
                'description' => "Banc composé de branches de teck assemblées et vernies, laissées dans leur forme d'origine. L'assise n'est jamais tout à fait plane : c'est ce qui en fait l'objet.\n\nDimensions : 100 x 35 x 45 cm. Branches de teck vernies. Pièce unique, aspect variable d'un exemplaire à l'autre.",
                'price' => 320,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 6,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ---- Jardin & Extérieur ----
            [
                'category_id' => $jardin->id,
                'name' => 'Table de jardin Teck massif 180 cm',
                'description' => "Table d'extérieur en teck massif non traité, qui prendra sa patine grise argentée en une à deux saisons. Un huilage annuel suffit à conserver la teinte miel d'origine.\n\nDimensions : 180 x 90 x 75 cm. Teck massif d'origine contrôlée, assemblages chevillés, aucune visserie apparente. Convient à 6 convives, reste dehors toute l'année.",
                'price' => 890,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 4,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $jardin->id,
                'name' => 'Fauteuil de jardin Teck et corde',
                'description' => "Fauteuil bas d'extérieur, structure en teck massif et assise en corde marine tressée, qui sèche vite après la pluie et ne retient pas l'humidité.\n\nDimensions : 70 x 75 x 78 cm. Teck massif, corde polypropylène tressée main, traitée anti-UV. Empilable par deux.",
                'price' => 420,
                'compare_at_price' => null,
                'colors' => ['Corde écrue', 'Corde anthracite'],
                'stock' => 8,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ---- Décoration ----
            [
                'category_id' => $deco->id,
                'name' => 'Grand bol Racine de teck 60 cm',
                'description' => "Bol décoratif creusé dans une racine de teck, poncé à la main et laissé brut à l'intérieur. À poser sur une table basse ou une console ; il n'est pas étanche et ne va pas au contact alimentaire.\n\nDimensions : environ 60 cm de diamètre, 18 cm de haut. Racine de teck massive, finition cire incolore. Pièce unique.",
                'price' => 95,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 10,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ---- Bois & Chauffage ----
            [
                'category_id' => $bois->id,
                'name' => 'Bûches de chêne 50 cm — 1 stère',
                'description' => "Bois de chauffage en chêne fendu, séché deux ans sous abri ventilé. Taux d'humidité inférieur à 20 %, mesuré avant expédition : un bois plus humide encrasse le conduit et chauffe moitié moins.\n\nQuantité : 1 stère (bûches de 50 cm). Chêne français, séchage naturel 24 mois, humidité < 20 %. Livré sur palette, déchargement au pied de la propriété, sur rendez-vous.",
                'price' => 89,
                'compare_at_price' => null,
                'sizes' => ['Bûches 33 cm', 'Bûches 50 cm'],
                'colors' => null,
                'stock' => 40,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Bûches de hêtre 33 cm — 1 stère',
                'description' => "Hêtre fendu, séché deux ans. Il monte en température plus vite que le chêne et convient bien aux poêles et inserts de petite chambre de combustion.\n\nQuantité : 1 stère (bûches de 33 cm). Hêtre français, séchage naturel 24 mois, humidité < 20 %. Livré sur palette, déchargement au pied de la propriété.",
                'price' => 95,
                'compare_at_price' => null,
                'sizes' => ['Bûches 33 cm', 'Bûches 50 cm'],
                'colors' => null,
                'stock' => 35,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Filet de bois d\'allumage 10 kg',
                'description' => "Petit bois de résineux sec, prêt à l'emploi, en filet refermable. De quoi allumer une trentaine de feux sans papier ni allume-feu chimique.\n\nQuantité : filet de 10 kg. Résineux séché, longueur 20 à 25 cm, humidité < 18 %. Expédié en colis standard.",
                'price' => 19,
                'compare_at_price' => 24,
                'colors' => null,
                'stock' => 60,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => [],
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
