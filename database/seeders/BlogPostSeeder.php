<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Bien choisir le bois de son mobilier : chêne, frêne ou noyer ?',
                'excerpt' => 'Trois essences massives dominent notre atelier. Voici comment choisir la vôtre selon l\'usage, la lumière de la pièce et le budget.',
                'body' => "Le chêne massif reste la référence pour les pièces qui doivent traverser les décennies : tables, buffets, assises très sollicitées. Il se patine avec le temps et supporte bien les huiles naturelles que nous utilisons en finition.\n\nLe frêne, plus clair et plus souple, convient parfaitement aux pièces qui demandent du galbe — un piétement de fauteuil, une structure courbe. Il est aussi légèrement plus léger à déplacer, ce qui compte pour des meubles que l'on réagence souvent.\n\nLe noyer, enfin, est le choix des pièces d'exception : sa teinte chaude et son veinage prononcé en font une essence qui se suffit à elle-même, sans surcharge décorative.\n\nDans les trois cas, nous privilégions le bois massif huilé plutôt que verni : la finition vieillit mieux, se rénove facilement à la maison, et laisse respirer le bois.",
                'cover_image' => 'img_bg_1.jpg',
                'published_at' => now()->subMonths(3),
            ],
            [
                'title' => 'Entretenir un fauteuil en béton ou en pierre reconstituée',
                'excerpt' => 'Le béton design a envahi nos intérieurs, mais son entretien reste mal connu. Nos conseils pour préserver la matière sans l\'abîmer.',
                'body' => "Contrairement aux idées reçues, le béton fibré utilisé dans notre mobilier n'est pas un matériau brut : il est traité en surface pour limiter la porosité. Un dépoussiérage régulier au chiffon sec ou légèrement humide suffit au quotidien.\n\nÉvitez les produits d'entretien acides (vinaigre, détartrants) qui attaquent la surface. Une tache tenace se traite avec un savon neutre dilué, jamais avec un produit abrasif.\n\nÀ l'extérieur, une pièce en béton craint surtout le gel répété en présence d'humidité stagnante : pensez à la protéger ou à la rentrer si votre région connaît des hivers rigoureux.",
                'cover_image' => 'img_bg_2.jpg',
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Composer un salon avec peu de pièces, mais les bonnes',
                'excerpt' => 'Un salon réussi n\'est pas un salon rempli. Voici notre méthode pour composer un espace avec un nombre volontairement limité de meubles.',
                'body' => "Nous conseillons souvent de partir d'une seule pièce forte — un fauteuil sculptural, une table basse au galbe marqué — et de construire le reste de l'espace autour, en retenue.\n\nLaisser du vide autour d'un meuble le met en valeur bien plus efficacement que de le noyer parmi d'autres pièces. C'est aussi une question d'usage : un salon avec moins de meubles se range plus facilement et vieillit mieux visuellement, sans effet de mode qui se démode.\n\nSi vous hésitez entre deux pièces, choisissez toujours celle dont la matière (bois massif, béton, cuir pleine fleur) vous semble la plus durable : c'est elle qui déterminera la longévité réelle de votre salon.",
                'cover_image' => 'img_bg_3.jpg',
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'Nos ateliers de fabrication ouvrent leurs portes',
                'excerpt' => 'Deux fois par an, nous invitons nos clients à visiter l\'atelier où sont façonnées nos pièces en bois massif.',
                'body' => "La prochaine session portes ouvertes aura lieu ce trimestre. Vous pourrez suivre, du plan à la pièce finie, les étapes de fabrication d'une chaise en frêne massif : débit du bois, façonnage, assemblage, finition à l'huile.\n\nCes visites sont aussi l'occasion de rencontrer les artisans qui travaillent sur les pièces que vous avez chez vous, et de comprendre pourquoi certains délais de fabrication sur-mesure prennent plusieurs semaines.\n\nLes places sont limitées : contactez-nous via notre page de contact pour réserver votre créneau.",
                'cover_image' => 'img_bg_4.jpg',
                'published_at' => now()->subWeeks(2),
            ],
            [
                'title' => 'Rangement : penser un intérieur qui évolue avec vous',
                'excerpt' => 'Un bon meuble de rangement se choisit pour les dix prochaines années, pas pour la déco du moment. Nos critères.',
                'body' => "Avant la couleur ou le style, nous regardons toujours la structure : un caisson en bois massif assemblé à queue d'aronde vieillira bien mieux qu'un panneau plaqué, même si la différence n'est pas visible en boutique.\n\nPensez aussi à la modularité : des étagères réglables en hauteur, des tiroirs qui peuvent être réorganisés, permettent au meuble de suivre les usages de la pièce dans le temps — un bureau qui devient une bibliothèque, une commode qui migre de la chambre à l'entrée.\n\nEnfin, un meuble trop grand pour l'usage du moment mais pensé pour durer reste souvent un meilleur choix qu'un meuble ajusté au plus près qui sera à l'étroit dans deux ans.",
                'cover_image' => 'img_bg_5.jpg',
                'published_at' => null,
            ],
        ];

        foreach ($posts as $data) {
            $coverFile = $data['cover_image'];
            $path = 'blog/'.$coverFile;

            if (! Storage::disk('public')->exists($path)) {
                Storage::disk('public')->put(
                    $path,
                    file_get_contents(__DIR__.'/assets/banners/'.$coverFile)
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
    }
}
