<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * The blog follows the catalogue. It previously advised on oak, teak and cane for a furniture
 * shop; none of that survives the change of trade.
 *
 * Rewritten around what is actually sold: choosing between a ride-on, a self-propelled mower and
 * a robot; battery versus petrol; sizing a flail mower to the tractor you already own; and the
 * two things buyers get wrong about firewood and pellets. Covers are the supplier's own product
 * photography, like the rest of the site.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Autoportée, tondeuse tractée ou robot : choisir selon la surface',
                'excerpt' => 'La surface décide, mais pas seule : la forme du terrain et le nombre d\'obstacles comptent autant. Comment trancher entre les trois familles.',
                'body' => "En dessous de 500 m², une tondeuse poussée suffit et tout le reste est du confort payé cher. Entre 500 et 1 500 m², la question devient celle du dos : une tondeuse tractée avance toute seule, on la guide au lieu de la pousser, et c'est ce qui change une corvée en promenade.\n\nAu-delà de 2 000 m², l'autoportée s'impose — mais pas n'importe laquelle. Le réflexe est de prendre le plateau le plus large possible ; c'est souvent une erreur. Sur un terrain planté d'arbres et bordé de massifs, une machine de 61 cm qui contourne les obstacles tond plus vite qu'une machine de 102 cm qui oblige à finir chaque contour à la débroussailleuse. Comptez les obstacles avant de compter les mètres carrés.\n\nLe robot est une autre logique : il ne tond pas mieux, il tond tout le temps. L'herbe ne dépasse jamais, il n'y a jamais rien à ramasser, et le temps de tonte devient nul. Sa vraie limite n'est pas la surface — les modèles récents gèrent plusieurs milliers de mètres carrés — mais le relief et le morcellement du terrain. Les générations sans fil périphérique, qui cartographient au LiDAR, ont largement levé la contrainte d'installation.\n\nEn pratique : tractée jusqu'à 1 500 m², autoportée au-delà si le terrain est ouvert, robot si le terrain est clos et que l'on veut cesser d'y penser.",
                'cover_image' => 'gb-30459.jpg',
                'published_at' => now()->subMonths(3),
            ],
            [
                'title' => 'Batterie ou thermique : ce qui a vraiment changé en motoculture',
                'excerpt' => 'La batterie n\'est plus le second choix qu\'elle était. Où elle a pris l\'avantage, et où le thermique reste indiscutable.',
                'body' => "Sur les outils portés à bout de bras — élagueuses, débroussailleuses légères, taille-haies — la batterie a gagné. Pas pour l'écologie : pour le poids et le démarrage. Une perche élagueuse à batterie n'a pas de moteur en haut de la perche, et l'on ne tire pas un lanceur en équilibre sous une branche. À cela s'ajoute ce que personne ne mentionne dans les fiches techniques : le silence. On entend la branche craquer avant qu'elle ne tombe.\n\nSur les tondeuses jusqu'à 1 000 m², la batterie a gagné aussi. Plus de mélange, plus de bougie, plus de filtre à air, plus de vidange, et une machine que l'on peut ranger dans un garage attenant sans odeur de carburant.\n\nLe thermique garde deux terrains. Le premier est la durée : une journée entière de débroussaillage ou de broyage demande une réserve d'énergie qu'aucune batterie raisonnable ne porte encore. Le second est le couple bas régime — un motoculteur qui entre dans une terre lourde, une tronçonneuse d'abattage dans un tronc de chêne. C'est là que le diesel et le 2 temps restent sans équivalent.\n\nUn conseil qui vaut plus que le débat : quand vous achetez à batterie, achetez dans une seule gamme. La valeur d'un outil sans fil tient à ce que sa batterie serve aussi aux trois autres.",
                'cover_image' => 'gb-29006.png',
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Choisir un broyeur pour son tracteur : largeur, série, chevaux',
                'excerpt' => 'L\'erreur la plus fréquente n\'est pas d\'acheter trop petit, mais trop lourd pour le tracteur que l\'on a. Les trois chiffres à regarder.',
                'body' => "Premier chiffre : la puissance demandée. Chaque broyeur annonce une plage de tracteur — de 10 à 20 CV pour un modèle de 93 cm, de 30 à 45 CV pour un 130 cm, de 50 à 80 CV pour un 180 cm de série lourde. Ce n'est pas une indication commerciale. En dessous de la plage, la prise de force peine et le rotor ne monte pas en régime ; au-dessus, on casse la transmission du broyeur.\n\nDeuxième chiffre : le poids. Un broyeur porté travaille en porte-à-faux au bout du relevage. 110 kg sur un micro-tracteur, c'est déjà sensible ; 495 kg demandent une machine qui a le contrepoids et les pneus pour. Beaucoup d'acheteurs choisissent la largeur d'abord et découvrent ensuite que l'avant de leur tracteur se lève.\n\nTroisième chiffre : la série. Légère pour l'herbe, les sarments et les petits arbustes — l'entretien courant d'un pré. Médium pour ce qui traîne au sol après une taille, avec marteaux dentés, contre-lame et tiges de ramassage. Lourde pour un usage d'exploitation, plusieurs heures par jour, des années durant.\n\nReste le déport. Manuel, il se règle à l'arrêt, une fois par chantier : suffisant si vous broyez surtout des surfaces ouvertes. Hydraulique, il se commande du siège en travaillant : indispensable dès que l'on longe des rangs, des clôtures ou des fossés, où il fait gagner près d'une heure par hectare.",
                'cover_image' => 'gb-17885.jpg',
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'Bois de chauffage : le stère, l\'humidité et la longueur de bûche',
                'excerpt' => 'Trois notions expliquent presque tous les malentendus à la livraison. Une fois comprises, on compare enfin les offres entre elles.',
                'body' => "Le stère est un volume apparent, bûches empilées, vides compris — et il dépend de la longueur de coupe. Un stère de bûches de 50 cm occupe environ 0,80 m³ ; le même stère coupé en 33 cm n'occupe plus que 0,60 m³, parce que le bois court s'empile mieux et laisse moins de vide. La quantité de bois est identique. C'est la source d'à peu près toutes les disputes à la livraison : comparez des stères, jamais des mètres cubes.\n\nL'humidité décide du reste. À 23 %, un bois n'est pas prêt : il chauffe environ deux fois moins parce qu'une partie de l'énergie part à évaporer l'eau, et il encrasse le conduit — c'est-à-dire qu'il coûte un ramonage supplémentaire et augmente le risque de feu de cheminée. En dessous de 20 %, il est utilisable ; autour de 15 %, il est bon. Un bois vendu à sécher n'est pas un mauvais bois : c'est le moyen le moins cher de se chauffer, à condition d'avoir l'abri ventilé et surélevé, et dix-huit mois devant soi.\n\nLa longueur, enfin, se choisit sur le foyer et non sur le prix au stère. 50 cm pour un foyer ouvert ou un grand insert, 33 cm pour la plupart des poêles, 25 cm pour les petits. Le bois trop long que l'on recoupe soi-même annule l'économie réalisée à l'achat.\n\nEt si vous n'avez pas d'abri : les bûches densifiées tiennent dans un coin de garage, quatre fois moins encombrantes pour trois fois plus d'énergie.",
                'cover_image' => 'gb-29689.webp',
                'published_at' => now()->subWeeks(2),
            ],
            [
                'title' => 'Granulés : lire une étiquette DIN Plus ou EN Plus A1',
                'excerpt' => 'Cinq chiffres séparent un granulé qui encrasse d\'un granulé qui dure. Ce que les certifications garantissent réellement.',
                'body' => "Le pouvoir calorifique vient en premier : entre 4,6 et 5 kWh/kg pour un bon granulé. C'est ce que vous achetez réellement, et l'écart entre 4,6 et 4,9 se traduit directement en nombre de sacs sur une saison.\n\nL'humidité doit rester sous 10 %, et sous 8 % c'est mieux. Un granulé humide gonfle, colle et finit par bloquer la vis sans fin du poêle — la panne la plus banale et la plus évitable. C'est aussi pourquoi une palette se stocke au sec, jamais contre un mur de garage qui suinte.\n\nLe taux de cendres, sous 0,7 % en EN Plus A1 et souvent sous 0,5 % chez les meilleurs, décide de la fréquence à laquelle vous videz le cendrier. Le taux de fines, sous 0,5 %, décide de la propreté de la vitre et de l'encrassement de l'alimentation : un sac transparent permet de le juger à l'œil avant même d'ouvrir.\n\nLa durabilité mécanique, enfin — au moins 98 % — est le chiffre que personne ne regarde et qui explique les autres. Elle mesure la résistance du granulé à la casse pendant le transport et le passage dans la vis. Un granulé fragile arrive en poussière, et cette poussière est exactement ce que l'on ne veut pas.\n\nRésineux ou feuillus : les résineux montent plus vite en température et laissent moins de cendres, les feuillus tiennent plus longtemps. Les deux fonctionnent ; regardez les cinq chiffres avant l'essence.",
                'cover_image' => 'gb-9315.jpg',
                'published_at' => null,
            ],
        ];

        foreach ($posts as $data) {
            $coverFile = $data['cover_image'];
            $path = 'blog/'.$coverFile;

            if (! Storage::disk('public')->exists($path)) {
                Storage::disk('public')->put(
                    $path,
                    file_get_contents(__DIR__.'/assets/products/'.$coverFile)
                );
            }

            BlogPost::query()->updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'cover_image' => $path,
                    'published_at' => $data['published_at'],
                ]
            );
        }

        // Posts from the furniture catalogue (oak versus teak, composing a living room) would
        // otherwise still be listed under a shop that now sells chainsaws.
        BlogPost::query()
            ->whereNotIn('slug', array_map(fn ($p) => Str::slug($p['title']), $posts))
            ->delete();
    }
}
