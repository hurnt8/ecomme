<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * The shop's own catalogue. The nine demo products that came with the template (the concrete
 * rocking chair, the speaker, the money box and the rest) have been removed: they were the
 * template's furniture, not this shop's, and their photographs were the only reason they were
 * kept this long.
 *
 * None of these products carries an image. The template's nine photographs belonged to those
 * demo items, and photography for real stock is the shop's to supply — uploaded per product
 * through the back office. Until then Product::thumbnail_url shows a neutral placeholder rather
 * than borrowing another item's picture.
 *
 * Descriptions open on what the piece is like to live with, then give the specifics a buyer
 * needs before ordering: dimensions, essence, finish, and how it arrives.
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
            // ---------------------------------------------------------------- Salle à manger
            [
                'category_id' => $mobilier->id,
                'name' => 'Table à manger Grand Chêne 200 cm',
                'description' => "Une table pour les dimanches qui s'étirent. Le plateau, d'une seule épaisseur de chêne massif, garde les nuances du billon dont il vient : plus clair ici, profondément veiné là. Il repose sur un piétement d'acier en X qui le fait paraître flotter — et qui, surtout, laisse les jambes tranquilles jusqu'au bout de la table.\n\nLe chêne est huilé, jamais verni. La marque d'un verre s'estompe d'un coup de chiffon ; une rayure se ponce à l'endroit exact, sans reprendre la table entière. C'est un meuble qui vieillit au lieu de s'user.\n\nDimensions : 200 x 100 x 76 cm, huit convives à l'aise. Plateau chêne massif 4 cm, piétement acier laqué noir, finition huile naturelle. Livrée plateau et piétement séparés : vingt minutes de montage à deux.",
                'price' => 1290,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 4,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Table à manger Acacia Live Edge 180 cm',
                'description' => "Les deux longs chants de cette table ont été laissés tels que l'arbre les a dessinés : une ligne qui ondule, s'élargit, se resserre. Rien n'a été redressé. C'est pour cette raison qu'aucune de ces tables n'est tout à fait identique à la suivante, et que la largeur varie de quelques centimètres d'un exemplaire à l'autre.\n\nL'acacia est un bois dense, presque impossible à marquer, dont la teinte miel fonce lentement avec la lumière. Le piétement trapèze en acier reste volontairement discret : c'est le plateau qu'on doit voir.\n\nDimensions : 180 x 90 (±4) x 76 cm, six convives. Acacia massif 4 cm, chants naturels poncés main, piétement acier. Chaque plateau est unique.",
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
                'description' => "Le banc règle une question que les chaises posent toujours : combien tient-on autour de la table ? Trois adultes, ou quatre enfants qui se serrent. Et quand le repas est fini, il glisse entièrement sous le plateau et la pièce se dégage.\n\nMême chêne massif et même piétement en X que la table Grand Chêne, pour que l'ensemble se réponde sans effet de série.\n\nDimensions : 180 x 35 x 45 cm. Chêne massif, piétement acier laqué noir, finition huile naturelle.",
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
                'name' => 'Chaise Acacia assise garnie',
                'description' => "Une chaise dans laquelle on reste. Le dossier est légèrement incliné, l'assise garnie d'une mousse haute résilience qui ne s'affaisse pas au bout d'un hiver : ce sont les deux détails qui font qu'on prolonge le café plutôt que de se lever.\n\nLa structure est en acacia massif, le tissu au tissage serré résiste à 40 000 tours Martindale — l'ordre de grandeur qu'on demande à un siège de restaurant.\n\nDimensions : 46 x 55 x 82 cm, hauteur d'assise 46 cm. Acacia massif, mousse haute résilience, tissu 100 % polyester. Housse non déhoussable.",
                'price' => 249,
                'compare_at_price' => null,
                'colors' => ['Gris clair', 'Anthracite'],
                'stock' => 24,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => [],
            ],

            // ------------------------------------------------------------------------- Salon
            [
                'category_id' => $mobilier->id,
                'name' => 'Table basse Racine de teck 60 cm',
                'description' => "Elle a d'abord été une souche. Taillée dans une racine de teck récupérée après abattage, poncée longuement puis vernie mate, elle garde ses nœuds, ses fentes et ses creux — on n'a rien rebouché. Posez-la dans un salon très dessiné : c'est le seul élément qui ne suivra aucune ligne droite, et c'est exactement ce qu'on lui demande.\n\nChaque pièce est unique, jusqu'au poids, qui varie d'une souche à l'autre.\n\nDimensions : environ 60 x 60 x 40 cm. Racine de teck massive, finition vernis mat. Poids 18 à 25 kg.",
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
                'description' => "Un plateau franchement épais, tenu par un piétement en X si fin qu'il disparaît quand on regarde de face. Tout l'équilibre de cette table est là : la masse du chêne au-dessus, presque rien en dessous.\n\nAssez longue pour un plateau de fromages, assez haute pour qu'on y pose les pieds sans se contorsionner.\n\nDimensions : 110 x 60 x 40 cm. Chêne massif 4 cm, piétement acier laqué noir, finition huile naturelle.",
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
                'description' => "Suspendu, il rend au salon le mètre carré que les meubles TV confisquent toujours : l'aspirateur passe dessous, les câbles cessent de faire un nid, et la pièce paraît plus grande qu'elle ne l'est.\n\nTrois tiroirs à ouverture par poussée, sans une poignée qui vienne casser la façade en acacia massif. Les coulisses freinées se referment seules, en silence, même quand on pousse d'un genou.\n\nDimensions : 160 x 40 x 30 cm. Acacia massif, coulisses à fermeture douce, passe-câbles à l'arrière. Fixations pour mur plein fournies.",
                'price' => 690,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 5,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Bibliothèque Acacia 100 cm',
                'description' => "Les cases sont décalées : d'un côté la hauteur d'un roman de poche, de l'autre celle d'un beau livre posé à plat. C'est ce qui évite la rangée trop régulière, et ce qui permet de tout ranger sans rien coucher de travers.\n\nMontée sans une vis apparente, en acacia massif de bout en bout — y compris le fond, ce que la plupart des bibliothèques de ce prix ne font pas.\n\nDimensions : 100 x 35 x 180 cm, six cases. Acacia massif, finition huile naturelle. Système anti-bascule fourni.",
                'price' => 690,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 4,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ----------------------------------------------------------------------- Chambre
            [
                'category_id' => $mobilier->id,
                'name' => 'Lit Chêne et métal 180 x 200',
                'description' => "Une tête de lit pleine, en chêne massif, dont les montants ont été adoucis pour qu'on puisse s'y adosser longtemps sans chercher la bonne position. Le cadre repose sur des traverses d'acier noir : aucun pied central au milieu du passage, et 25 cm de dégagement au sol pour ranger dessous.\n\nLe sommier à lattes se pose directement sur le cadre. Le lit ne grince pas, parce que rien n'y est assemblé par simple vissage dans du panneau.\n\nDimensions : 196 x 216 x 90 cm, couchage 180 x 200. Chêne massif et acier laqué noir. Sommier et matelas non fournis.",
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
                'description' => "Assez large pour une lampe, un livre et un verre d'eau ; assez étroit pour ne pas manger le passage entre le lit et le mur. La niche ouverte reçoit ce qui traîne, le tiroir ferme sur ce qui doit disparaître.\n\nMême chêne et même acier noir que le lit Chêne et métal, pour que la chambre tienne ensemble.\n\nDimensions : 40 x 35 x 50 cm. Chêne massif, tiroir sur coulisses à fermeture douce, piétement acier laqué noir.",
                'price' => 190,
                'compare_at_price' => 225,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 12,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ------------------------------------------------------------------------ Entrée
            [
                'category_id' => $mobilier->id,
                'name' => "Banc d'entrée Branches de teck 100 cm",
                'description' => "Des branches de teck, assemblées les unes contre les autres et vernies, sans qu'aucune ait été redressée. L'assise n'est donc jamais tout à fait plane — c'est ce qui en fait un objet plutôt qu'un meuble, et ce pour quoi on le met dans une entrée, là où le regard tombe en arrivant.\n\nOn s'y assoit vraiment, le temps de retirer ses chaussures.\n\nDimensions : 100 x 35 x 45 cm. Branches de teck vernies. Aspect variable d'un exemplaire à l'autre : chaque banc est unique.",
                'price' => 320,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 6,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ------------------------------------------------------------- Jardin & Extérieur
            [
                'category_id' => $jardin->id,
                'name' => 'Table de jardin Teck massif 180 cm',
                'description' => "Le teck est le seul bois qu'on peut laisser dehors toute l'année sans y penser : sa densité et ses huiles naturelles le protègent seuls. Cette table prendra une patine gris argenté en une ou deux saisons — la teinte qu'on voit sur les terrasses de bord de mer. Si vous préférez le miel du premier jour, un huilage par an suffit à le retenir.\n\nLes assemblages sont chevillés, pas vissés : aucune vis ne rouillera à cœur au bout de cinq hivers.\n\nDimensions : 180 x 90 x 75 cm, six convives. Teck massif d'origine contrôlée. Reste dehors toute l'année.",
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
                'description' => "L'assise est tressée en corde marine, main. C'est ce qui change tout après une averse : l'eau traverse, la corde sèche en une heure, et on se rassoit sans aller chercher un coussin trempé au fond du garage.\n\nBas, légèrement incliné vers l'arrière, c'est un fauteuil de fin d'après-midi plus qu'un siège de repas. Il s'empile par deux pour l'hiver.\n\nDimensions : 70 x 75 x 78 cm. Structure teck massif, corde polypropylène tressée main, traitée anti-UV.",
                'price' => 420,
                'compare_at_price' => null,
                'colors' => ['Corde écrue', 'Corde anthracite'],
                'stock' => 8,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $jardin->id,
                'name' => 'Banc de jardin Teck 150 cm',
                'description' => "Un banc sans dossier, qu'on pousse contre un mur chaud ou qu'on laisse au bout de l'allée. Deux personnes largement, trois en se serrant. Sa vraie qualité est de ne pas avoir d'avant ni d'arrière : on s'y assoit du côté d'où l'on vient.\n\nTeck massif non traité, qui grisera comme la table de jardin assortie.\n\nDimensions : 150 x 40 x 45 cm. Teck massif d'origine contrôlée, assemblages chevillés. Reste dehors toute l'année.",
                'price' => 590,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 5,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // -------------------------------------------------------------------- Décoration
            [
                'category_id' => $deco->id,
                'name' => 'Grand bol Racine de teck 60 cm',
                'description' => "Soixante centimètres de diamètre : c'est le genre d'objet qui suffit à occuper une table basse, sans rien poser dedans. Creusé dans une racine de teck, poncé à la main dehors, laissé brut dedans — la différence de toucher entre les deux fait tout le plaisir de l'objet.\n\nÀ garnir de pommes de pin l'hiver, ou à laisser vide.\n\nDimensions : environ 60 cm de diamètre, 18 cm de haut. Racine de teck massive, finition cire incolore. Pièce unique. Non étanche, ne convient pas au contact alimentaire.",
                'price' => 95,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 10,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Miroir rond cadre Chêne 80 cm',
                'description' => "Un cercle de chêne massif de quatre centimètres d'épaisseur, et rien d'autre. Le cadre est assez profond pour projeter une ombre douce sur le mur : accroché dans une entrée un peu sombre, le miroir se détache au lieu de s'y fondre.\n\nLe verre est un miroir clair, sans traitement teinté qui fausserait les couleurs.\n\nDimensions : 80 cm de diamètre, 4 cm d'épaisseur. Chêne massif, finition huile naturelle, verre clair 4 mm. Fixation murale invisible fournie.",
                'price' => 180,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 9,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Photophores Teck — lot de 3',
                'description' => "Trois hauteurs différentes, tournées dans du teck massif : posés ensemble, ils font une petite composition ; séparés, ils tiennent chacun leur bout d'étagère. Le bois se réchauffe à la flamme et sent discrètement, ce qu'aucun photophore en verre ne fera.\n\nLivrés sans bougie ; ils reçoivent des chauffe-plats standard.\n\nDimensions : 8, 12 et 16 cm de haut, 7 cm de diamètre. Teck massif, insert métal pour bougie chauffe-plat.",
                'price' => 45,
                'compare_at_price' => 59,
                'colors' => null,
                'stock' => 22,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // --------------------------------------------------------------- Équipement Maison
            [
                'category_id' => $equipement->id,
                'name' => 'Portemanteau mural Chêne 5 patères',
                'description' => "Une barre de chêne massif et cinq patères tournées, espacées assez largement pour qu'un manteau d'hiver n'écrase pas celui d'à côté — le défaut de presque tous les portemanteaux muraux.\n\nSe visse dans deux points seulement, mais tient une charge réelle : la barre est pleine, pas plaquée.\n\nDimensions : 60 x 6 x 10 cm, cinq patères. Chêne massif, finition huile naturelle. Chevilles pour mur plein fournies.",
                'price' => 89,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 18,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $equipement->id,
                'name' => 'Escabeau Bois et métal 3 marches',
                'description' => "Assez beau pour rester dehors, ce qui est tout l'enjeu d'un escabeau : celui qu'on range finit au fond d'un placard, et on monte sur une chaise. Marches en hêtre massif, structure acier laqué, et une fois replié il tient contre un mur sur cinq centimètres d'épaisseur.\n\nLa dernière marche est assez large pour y tenir des deux pieds sans chercher l'équilibre.\n\nDimensions : 45 x 50 x 90 cm déplié, 5 cm d'épaisseur replié. Marches hêtre massif, structure acier laqué noir. Charge maximale 120 kg.",
                'price' => 140,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 11,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $equipement->id,
                'name' => 'Panier de rangement Jonc tressé',
                'description' => "Le panier où finit tout ce qui n'a pas de place : les plaids du salon, les jouets du soir, le linge à plier. Tressé en jonc de mer, il garde sa forme une fois vide au lieu de s'affaisser — c'est la seule chose qu'on demande vraiment à un panier.\n\nDeux anses cousues permettent de le déplacer chargé.\n\nDimensions : 45 cm de diamètre, 40 cm de haut. Jonc de mer tressé main, anses coton. Se vide et s'aspire ; ne pas laver à l'eau.",
                'price' => 55,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 26,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ------------------------------------------------------------------ Bois & Chauffage
            [
                'category_id' => $bois->id,
                'name' => 'Bûches de chêne 50 cm — 1 stère',
                'description' => "Du chêne fendu, séché deux ans sous abri ventilé. C'est la braise longue : celle qui tient encore le matin et qu'on relance d'une bûche au lieu de rallumer un feu.\n\nNous mesurons l'humidité avant chaque expédition et n'expédions pas au-dessus de 20 %. Ce n'est pas un détail de fiche technique : un bois trop humide chauffe moitié moins, encrasse le conduit et vous fait ramoner deux fois plus souvent.\n\nQuantité : 1 stère. Chêne français, séchage naturel 24 mois, humidité inférieure à 20 %. Livré sur palette, déchargement au pied de la propriété, sur rendez-vous.",
                'price' => 89,
                'compare_at_price' => null,
                'sizes' => ['Bûches 33 cm', 'Bûches 50 cm'],
                'colors' => null,
                'stock' => 40,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Bûches de hêtre 33 cm — 1 stère',
                'description' => "Le hêtre monte en température plus vite que le chêne et donne une flamme plus vive. C'est le bois des soirées où l'on veut que la pièce soit chaude tout de suite, et le format qui convient aux poêles et aux inserts à petite chambre de combustion.\n\nMême exigence de séchage que notre chêne : deux ans sous abri, humidité contrôlée avant départ.\n\nQuantité : 1 stère. Hêtre français, séchage naturel 24 mois, humidité inférieure à 20 %. Livré sur palette, déchargement au pied de la propriété.",
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
                'name' => "Filet de bois d'allumage 10 kg",
                'description' => "De quoi allumer une trentaine de feux sans journal froissé ni cube chimique. Du petit bois de résineux, sec, calibré court : deux poignées croisées, une allumette, et le feu prend seul pendant qu'on fait autre chose.\n\nLe filet se referme, donc le reste ne se répand pas dans le garage.\n\nQuantité : filet refermable de 10 kg. Résineux séché, longueur 20 à 25 cm, humidité inférieure à 18 %. Expédié en colis standard.",
                'price' => 19,
                'compare_at_price' => 24,
                'colors' => null,
                'stock' => 60,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Range-bûches Acier et Chêne',
                'description' => "Il tient l'équivalent de trois jours de feu à portée de main, ce qui évite la sortie sous la pluie au moment où le feu baisse. La structure en acier noir est ouverte sur les côtés : le bois continue de sécher à l'air de la pièce au lieu de suer contre une paroi.\n\nLa poignée supérieure en chêne massif sert vraiment : le range-bûches se déplace plein, d'une seule main.\n\nDimensions : 50 x 35 x 65 cm. Acier laqué noir, poignée chêne massif. Contenance environ 25 kg de bûches de 33 cm.",
                'price' => 240,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 14,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Serviteur de cheminée 4 pièces',
                'description' => "Pique-feu, pelle, balayette et pince, sur un pied qui les tient droits au lieu de les laisser glisser le long du mur. Les manches sont en chêne massif : ils ne chauffent pas comme le métal quand on les laisse trop près du foyer.\n\nAssez lourd pour qu'on décroche un outil sans que l'ensemble bascule — le défaut des serviteurs bon marché.\n\nDimensions : 20 x 20 x 68 cm. Acier laqué noir, manches chêne massif. Quatre outils inclus.",
                'price' => 130,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 16,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // --------------------------------------------------------- Chambre : rangement
            [
                'category_id' => $mobilier->id,
                'name' => 'Armoire Chêne massif 2 portes 190 cm',
                'description' => "Une armoire qui ne fait pas bloc. Les portes affleurent le caisson, sans encadrement rapporté, et la poignée est une simple gorge creusée dans l'épaisseur du chêne : de loin, on ne voit qu'un volume clair posé sur quatre pieds fuselés.\n\nDedans, la penderie occupe les deux tiers — assez pour des manteaux longs, ce que beaucoup d'armoires de cette largeur ne permettent pas — et trois étagères réglables prennent le reste.\n\nDimensions : 120 x 60 x 190 cm. Chêne massif et placage chêne sur âme alvéolaire pour les portes, penderie 130 cm, trois étagères réglables. Livrée montée, prévoir deux personnes.",
                'price' => 1590,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 3,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Commode Chêne 6 tiroirs 110 cm',
                'description' => "Six tiroirs sur deux rangs, tous de la même hauteur : on range par catégorie plutôt que par taille, et rien ne finit coincé au fond d'un grand tiroir. Les coulisses sortent en totalité — le dernier pull est aussi accessible que le premier.\n\nLe plateau est d'une seule pièce de chêne massif, assez profond pour une lampe et un plateau à bijoux sans que l'ensemble déborde.\n\nDimensions : 110 x 40 x 90 cm. Chêne massif, six tiroirs sur coulisses à sortie totale et fermeture douce, piétement fuselé. Livrée montée.",
                'price' => 1190,
                'compare_at_price' => 1390,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 5,
                'is_new' => false,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Tête de lit Mosaïque bois 160 cm',
                'description' => "Des dizaines de petits carrés de bois recyclé, assemblés à la main, chacun avec sa teinte d'origine : un panneau qui change de couleur selon l'heure et l'éclairage. C'est la pièce qui habille un mur de chambre resté nu, sans qu'on ait à repeindre.\n\nSe fixe au mur, ou se glisse simplement derrière le lit et prend appui contre la cloison.\n\nDimensions : 160 x 5 x 120 cm, pour un couchage 140 à 160 cm. Bois recyclé assemblé main, finition cire mate. Fixations murales fournies. Chaque panneau est unique.",
                'price' => 450,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 7,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Coffre de rangement Bois recyclé 125 cm',
                'description' => "Un coffre au pied du lit règle deux problèmes d'un coup : les couvertures de mi-saison trouvent une place, et on a enfin où s'asseoir pour se chausser.\n\nCelui-ci est monté en bois recyclé aux frises sculptées, avec un couvercle à charnières freinées qui ne retombe pas sur les doigts. Le bois porte ses anciennes traces — clous, teintes, petits manques — et c'est ce qui fait qu'il n'a pas l'air neuf dans une chambre ancienne.\n\nDimensions : 125 x 50 x 45 cm. Bois recyclé massif, charnières freinées, intérieur brut poncé. Pièce unique.",
                'price' => 490,
                'compare_at_price' => 690,
                'colors' => null,
                'stock' => 4,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ------------------------------------------------------------- Bureau & travail
            [
                'category_id' => $mobilier->id,
                'name' => 'Bureau Chêne huilé 130 cm',
                'description' => "Un plateau franc, sans caisson ni retour : de quoi poser un écran, un cahier et un café, et pouvoir tout dégager en dix secondes quand la table redevient une table.\n\nLe passe-câbles est décalé à l'arrière gauche, là où arrive la prise dans la plupart des pièces, et le chêne huilé ne renvoie pas la lumière d'une fenêtre en pleine face comme le fait un plateau verni.\n\nDimensions : 130 x 70 x 76 cm. Chêne massif huilé, piétement acier laqué noir, passe-câbles intégré. Hauteur compatible avec un fauteuil de bureau standard.",
                'price' => 790,
                'compare_at_price' => null,
                'colors' => ['Chêne naturel', 'Chêne fumé'],
                'stock' => 6,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Bureau ministre Pin massif 160 cm',
                'description' => "Le vrai bureau, celui devant lequel on s'installe pour la journée : 160 cm de plateau, une porte et quatre tiroirs, dont un à suspension pour les dossiers.\n\nLe pin massif est ciré miel, pas verni — le bois reste chaud sous l'avant-bras, ce qui compte quand on écrit longtemps. Il se patine, et une trace de stylo se reprend à la cire sans détourer toute la surface.\n\nDimensions : 160 x 75 x 78 cm. Pin massif, finition cire miel, une porte et quatre tiroirs dont un dossier suspendu. Livré monté.",
                'price' => 895,
                'compare_at_price' => 995,
                'colors' => ['Cire miel', 'Cire blanche'],
                'stock' => 4,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => 'Secrétaire Pin massif 2 portes 6 tiroirs',
                'description' => "L'abattant se referme et le désordre disparaît avec lui : le secrétaire est le seul bureau qu'on peut laisser en plan au milieu du salon.\n\nDerrière, six petits tiroirs et deux portes tiennent le courrier, les factures et ce qui traîne. Ouvert, l'abattant offre une surface d'écriture stable, soutenue par deux coulisseaux en bois plein.\n\nDimensions : 90 x 45 x 110 cm, plan de travail à 78 cm une fois ouvert. Pin massif ciré, six tiroirs, deux portes. Livré monté.",
                'price' => 699,
                'compare_at_price' => null,
                'colors' => ['Cire miel', 'Cire blanche'],
                'stock' => 5,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $mobilier->id,
                'name' => "Bureau d'angle Pin massif",
                'description' => "Il occupe le coin que rien d'autre ne remplit — celui qu'on laisse vide depuis l'emménagement — et rend un poste de travail complet sans manger le passage.\n\nUne tablette basse reçoit l'unité centrale ou l'imprimante, et le retour est assez profond pour un second écran.\n\nDimensions : 120 x 120 x 75 cm, profondeur des plateaux 55 cm. Pin massif ciré, tablette basse. Montage à prévoir, notice fournie.",
                'price' => 249,
                'compare_at_price' => null,
                'colors' => ['Cire miel', 'Cire blanche'],
                'stock' => 9,
                'is_new' => false,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ------------------------------------------------------------- Décoration murale
            [
                'category_id' => $deco->id,
                'name' => 'Miroir Teck recyclé brossé 110 x 80 cm',
                'description' => "Le cadre est monté en lames de teck recyclé, brossées jusqu'à faire ressortir le fil du bois. Les lames n'ont pas toutes la même teinte : c'est du bois de seconde vie, et le cadre en garde la mémoire.\n\nAssez grand pour renvoyer une pièce entière — accroché face à une fenêtre, il fait ce qu'aucune lampe ne fait : il double la lumière du jour.\n\nDimensions : 110 x 80 cm, cadre 6 cm. Teck recyclé brossé, verre clair 4 mm. Se pose à l'horizontale ou à la verticale. Fixations fournies.",
                'price' => 279,
                'compare_at_price' => 350,
                'colors' => null,
                'stock' => 6,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],
            [
                'category_id' => $deco->id,
                'name' => 'Décoration murale Bois de bateau 100 cm',
                'description' => "Un panneau composé de fragments de coques de bateaux de pêche, découpés et réassemblés. Les peintures d'origine — bleu délavé, rouge, blanc écaillé — n'ont été ni poncées ni retouchées : chaque couleur a passé des années en mer avant d'arriver là.\n\nC'est le genre de pièce qui suffit à un mur, et qui rend inutile tout ce qu'on aurait accroché autour.\n\nDimensions : 100 x 5 x 100 cm. Bois de bateau recyclé, patines d'origine, cadre en teck. Pièce unique : aucun panneau n'est identique à la photo. Fixations fournies.",
                'price' => 390,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 3,
                'is_new' => true,
                'is_bestseller' => false,
                'images' => [],
            ],

            // ------------------------------------------------------- Bois & Chauffage : granulés
            [
                'category_id' => $bois->id,
                'name' => 'Granulés de bois résineux — sac de 15 kg',
                'description' => "Le sac d'appoint : celui qu'on prend pour finir la semaine, ou pour essayer avant de commander une palette.\n\nGranulés de résineux pur, sans écorce ni liant — c'est ce qui donne peu de cendres et évite de vider le cendrier tous les deux jours. Certifiés DINplus et ENplus A1 : les deux références qui garantissent le taux d'humidité, le taux de cendres et le pouvoir calorifique, et que la plupart des fabricants de poêles exigent au titre de la garantie.\n\nSac de 15 kg. Granulés 6 mm, résineux, humidité inférieure à 10 %, taux de cendres inférieur à 0,7 %, environ 4,8 kWh/kg. Certification DINplus / ENplus A1.",
                'price' => 7,
                'compare_at_price' => null,
                'colors' => null,
                'stock' => 200,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Granulés de bois — palette de 66 sacs (990 kg)',
                'description' => "La commande d'une saison de chauffe pour un poêle, à peu près une tonne. C'est le format qui fait vraiment baisser le prix au kilo, et qui évite de repasser commande en janvier, au moment précis où tout le monde le fait et où les délais s'allongent.\n\nMêmes granulés certifiés que le sac à l'unité. Livrés filmés sur palette, à stocker au sec : un granulé qui prend l'humidité gonfle et bloque la vis sans fin du poêle.\n\nPalette de 66 sacs de 15 kg, soit 990 kg. Granulés 6 mm, résineux, humidité inférieure à 10 %, cendres inférieures à 0,7 %. Certification DINplus / ENplus A1. Livraison sur rendez-vous par camion à hayon, dépose au pied de la propriété sur sol stabilisé.",
                'price' => 399,
                'compare_at_price' => 449,
                'colors' => null,
                'stock' => 25,
                'is_new' => true,
                'is_bestseller' => true,
                'images' => [],
            ],
            [
                'category_id' => $bois->id,
                'name' => 'Bûches densifiées jour & nuit — pack de 12',
                'description' => "Deux bûches compressées pour deux usages. Les claires, en résineux, montent vite en température : c'est la flambée du soir. Les sombres, en feuillus, brûlent lentement et tiennent la nuit — on en met une avant de se coucher et il reste des braises au matin.\n\nElles ne font pas de fumée noire et laissent très peu de cendres. Pratiques quand on n'a pas d'abri à bûches : un pack se range dans un placard.\n\nPack de 12 bûches (6 jour, 6 nuit), environ 10 kg. Sciure compressée sans liant ni colle, humidité inférieure à 8 %. Une bûche nuit tient environ 4 heures.",
                'price' => 24,
                'compare_at_price' => 29,
                'colors' => null,
                'stock' => 80,
                'is_new' => true,
                'is_bestseller' => false,
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

            // Kept for when photography arrives: drop a file in seeders/assets/products and name
            // it in the product's 'images' array.
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
