<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * The blog that came with the template described a different shop: it advised on maintaining a
 * concrete armchair, compared frêne and noyer, and announced open days at "our manufacturing
 * workshops". None of that survives contact with this catalogue — there is no concrete furniture,
 * no ash or walnut, and the About page states plainly that we select rather than manufacture.
 *
 * Rewritten around what is actually sold: oak, teak, cane, reclaimed boat wood, stone, and
 * firewood. Covers are the supplier's own product photography, like the rest of the site.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Chêne, teck ou bois recyclé : quelle essence pour quelle pièce ?',
                'excerpt' => 'Trois familles de bois traversent notre sélection, et elles ne servent pas aux mêmes usages. Comment choisir selon la pièce, la lumière et l\'humidité.',
                'body' => "Le chêne massif est le bois des pièces de vie. Dense, clair, il se patine lentement et supporte l'huile plutôt que le vernis — une rayure se reprend à l'endroit exact, sans reponcer le meuble entier. C'est l'essence de nos lits, commodes et bibliothèques : des meubles qu'on garde vingt ans et qu'on déplace de logement en logement.\n\nLe teck est un cas à part. Ses huiles naturelles le rendent insensible à l'humidité permanente, ce qui explique qu'on le retrouve à la fois sur les terrasses et dans les salles de bain. Un meuble sous-vasque en panneau mélaminé gonfle et cloque au bout de deux ou trois ans ; en teck massif, non.\n\nLe bois recyclé — vieilles charpentes indiennes, bordages de bateaux de pêche — n'est pas choisi pour ses performances mais pour ce qu'il raconte. Trous de cheville, fentes de séchage, anciennes peintures : ce sont des marques d'usage conservées volontairement. Deux pièces ne sont jamais identiques, et c'est le principe.\n\nEn pratique : chêne pour ce qui doit durer et rester sobre, teck pour ce qui prend l'eau, bois recyclé pour la pièce qui donne le caractère d'une pièce.",
                'cover_image' => 'mp-12718.jpg',
                'published_at' => now()->subMonths(3),
            ],
            [
                'title' => 'Le teck en salle de bain : pourquoi il ne craint pas l\'humidité',
                'excerpt' => 'La salle de bain est la pièce qui détruit les meubles. Le teck y tient là où le mélaminé cède — voici ce qui se passe dans la matière.',
                'body' => "Un meuble de salle de bain vit dans une vapeur quotidienne, avec des cycles d'humidité et de séchage plusieurs fois par jour. C'est ce cycle, plus que l'eau elle-même, qui détruit les meubles : le panneau de particules absorbe, gonfle, et le placage se décolle par le chant. Deux à trois ans suffisent.\n\nLe teck contient naturellement des huiles et de la silice qui limitent fortement cette absorption. Il n'a pas besoin d'un traitement d'étanchéité rapporté qui finirait par s'écailler : la protection est dans la fibre. C'est pour cette raison que nos meubles sous-vasque sont massifs sur toutes leurs faces, y compris le dessous — la partie qui prend le plus d'humidité et que personne ne regarde.\n\nL'entretien tient en une phrase : essuyer l'eau stagnante, et passer une huile pour teck une fois par an si vous voulez garder la teinte miel. Sans huilage, le bois grisera lentement — ce qui n'enlève rien à sa résistance, seulement à sa couleur.\n\nÀ éviter en revanche : les détartrants et les nettoyants acides, surtout à proximité d'une vasque en pierre ou en marbre, qu'ils matent définitivement.",
                'cover_image' => 'mp-16211.webp',
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Composer un salon avec peu de pièces, mais les bonnes',
                'excerpt' => 'Un salon réussi n\'est pas un salon rempli. Notre méthode pour composer un espace avec un nombre volontairement limité de meubles.',
                'body' => "Partez d'une seule pièce forte — une table basse en bois de bateau, un meuble TV en cannage, une bibliothèque en chêne — et construisez le reste en retenue. Laisser du vide autour d'un meuble le met en valeur bien plus efficacement que de l'entourer d'autres meubles.\n\nC'est aussi une question d'usage. Un salon avec moins de meubles se range plus vite, se réagence sans déménagement, et vieillit mieux visuellement : les compositions chargées datent, les compositions simples non.\n\nUne règle utile quand on hésite entre deux pièces : choisissez celle dont la matière est massive. Entre deux meubles au même prix, celui en bois massif sera encore là quand l'autre aura été remplacé, et c'est lui qui déterminera la longévité réelle de la pièce.\n\nDernier point, souvent négligé : la hauteur. Trois meubles bas dans une pièce donnent une impression de plafond écrasé. Une seule verticale — une bibliothèque colonne, une armoire — suffit à rééquilibrer l'ensemble.",
                'cover_image' => 'mp-12994.jpg',
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'Cannage, racine de teck, bois de bateau : d\'où viennent nos matières',
                'excerpt' => 'Nous ne fabriquons pas : nous choisissons. Voici ce que nous regardons avant de retenir une pièce, et ce que ces matières impliquent.',
                'body' => "Le cannage est un rotin tressé main, panneau par panneau. Sur une armoire ou un meuble TV, il n'est pas seulement décoratif : il ventile. Du linge rangé derrière une façade pleine prend l'odeur de renfermé ; derrière du cannage, non. Un décodeur enfermé chauffe ; derrière du rotin, il respire.\n\nLa racine de teck est ce qui reste après l'abattage. La souche est arrachée, séchée deux ans, puis tranchée à plat en haut et en bas — le reste, les creux et les entrelacs, est laissé tel quel. Aucune pièce ne ressemble à la suivante, ce qui veut dire concrètement que la photo montre l'esprit de la sélection, pas l'exemplaire exact qui partira.\n\nLe bois de bateau vient de bateaux de pêche indonésiens démontés. Chaque planche garde sa peinture d'origine, poncée juste assez pour être lisse sous la main sans effacer l'usure. C'est la matière la plus colorée de notre sélection, et celle qui dispense d'ajouter quoi que ce soit d'autre dans la pièce.\n\nCe que nous regardons avant de retenir une pièce, dans l'ordre : que le bois soit massif et non plaqué ; que la finition soit une huile ou une cire, réparable à la maison ; et que les assemblages tiennent sans dépendre d'une seule vis.",
                'cover_image' => 'mp-8227.jpg',
                'published_at' => now()->subWeeks(2),
            ],
            [
                'title' => 'Rangement : penser un intérieur qui évolue avec vous',
                'excerpt' => 'Un bon meuble de rangement se choisit pour les dix prochaines années, pas pour la déco du moment. Nos critères.',
                'body' => "Avant la couleur ou le style, regardez la structure. Un caisson en bois massif vieillira mieux qu'un panneau plaqué, même si la différence ne saute pas aux yeux sur une photo. Regardez aussi le fond du meuble : un fond en panneau de particules agrafé derrière un meuble massif trahit l'économie faite là où personne ne regarde — sauf quand le meuble est vu de trois quarts.\n\nSur les tiroirs, un seul critère compte vraiment : la sortie totale. Un tiroir qui ne s'ouvre qu'aux deux tiers oblige à vider le devant pour atteindre le fond, et le fond finit par ne plus servir.\n\nPensez à la modularité. Des étagères réglables, des tiroirs réorganisables, permettent au meuble de suivre les usages de la pièce : un bureau qui devient une bibliothèque, une commode qui migre de la chambre à l'entrée.\n\nEnfin, mesurez les portes et les paliers avant de commander une armoire ou un lit en 180. Un meuble massif livré monté ne se démonte pas facilement, et c'est le motif de retour le plus fréquent — celui qu'un mètre ruban évite.",
                'cover_image' => 'mp-12706.jpg',
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

        // The template's five posts described a different shop (a concrete armchair, ash and
        // walnut, open days at workshops we do not have) and would otherwise still be listed.
        BlogPost::query()
            ->whereNotIn('slug', array_map(fn ($p) => Str::slug($p['title']), $posts))
            ->delete();
    }
}
