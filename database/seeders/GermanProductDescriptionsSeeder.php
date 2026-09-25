<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * German descriptions for the products on the storefront.
 *
 * Written by hand after a machine-translation trial failed on exactly the vocabulary these
 * listings turn on: LibreTranslate rendered "buches" as "Protokolle" (minutes of a meeting) and
 * then "Logs" in the same paragraph, because it pivots through English with no direct fr-de
 * model. On product 3661 that would have been worse than clumsy — the listing explains that a
 * stere of 50 cm logs fills 0.80 m3 against 0.60 m3 cut to 33 cm, which only holds if "stere"
 * stays Raummeter and does not become Kubikmeter.
 *
 * Runs after ProductSeeder for the same reason as GermanProductNamesSeeder: re-seeding the
 * catalogue would otherwise restore the French text without a word of warning.
 *
 * Covers the 28 products the homepage carousels and the first catalogue page put in front of
 * a visitor; the rest of the catalogue still carries its French descriptions.
 */
class GermanProductDescriptionsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (self::DESCRIPTIONS as $id => $text) {
            Product::query()->whereKey($id)->update(['description' => $text]);
        }
    }

    private const DESCRIPTIONS = [
        3331 => 'Die echte Kettensäge dieses Sortiments — die, die fällt und Brennholz macht. 5600 W bei 7,4 kg: genau das Verhältnis, das Forstprofis suchen. Drehmoment genug, um im Eichenstamm nicht abzuwürgen, und leicht genug, um sie einen Vormittag lang zu führen.

Für den gelegentlichen Ast im Garten ist sie nicht gedacht — dafür sind die Akku-Hochentaster dieses Sortiments vernünftiger und deutlich weniger anstrengend. Diese Säge ist zum Fällen gemacht, zum Ablängen von Stammholz und für die Raummeter, die man sich selbst aufbereitet.

Zweitaktmotor, Leistung 5600 W. Gewicht 7,4 kg. Husqvarna Forst-Profireihe. Persönliche Schutzausrüstung dringend empfohlen, nicht im Lieferumfang.',
        3332 => 'Extratrocken (mindestens 18 Monate) stammen die Weißeichenscheite aus nachhaltig bewirtschafteten französischen Wäldern der Franche-Comté, der Vogesen und des Juras. Weißeiche ist ein dichtes Holz, das im Gebrauch eine schöne Glut bildet. Sie verbrennt gleichmäßig und liefert einen hohen Heizwert. Weißeichen-Brennholz raucht wenig, brennt langsam ab und verschmutzt Ihre Feuerstätte kaum.',
        3333 => 'Die Premium-Scheite haben einen hohen Heizwert und eine Restfeuchte unter 20 %. Sie sind gespalten und in der Entrindungstrommel gereinigt, was das Anfeuern beschleunigt. Premium-Scheite geben sehr schnell behagliche Wärme ab und hinterlassen nur wenig Asche. Sie sind sauber und gleichmäßig, einfach zu handhaben und zu lagern.

PRAKTISCH
Sie genießen ein schönes Holzfeuer ohne die üblichen Mühen dieser Heizart: kein Spalten, kein aufwendiges Lagern, wenig Asche, keine verrußte Sichtscheibe, kein Glanzruß im Schornstein, keine Verschmutzung.

INNOVATIV
Crépito® richtet sich nach den neuen technischen Anforderungen moderner Holzfeuerstätten und macht aus dem klassischen Scheit ein Brennholz mit hoher Energieleistung.

LEISTUNGSSTARK
Die Crépito® Premium-Scheite haben einen hohen Heizwert, sind sehr trocken (unter 20 % Restfeuchte), gespalten und in der Entrindungstrommel gereinigt. Das Anfeuern geht dadurch schneller und die behagliche Wärme kommt früher, bei sehr geringem Ascheanteil. So erreichen Sie maximale Energieeffizienz und verlängern die Lebensdauer von Ofen und Schornstein.

VERFÜGBAR
Das neue Fertigungsverfahren macht die Crépito® Premium-Scheite das ganze Jahr über lagerfähig und lieferbar. Sie werden in Bündeln geliefert, die sich bequem stapeln lassen.

Die Vorzüge der Crépito® Premium-Scheite
Crépito® hat einen modernen Produktionskreislauf aufgebaut, einzigartig in Europa. Geliefert wird ein Produkt aus 100 % Holz — die günstigste Kilowattstunde aus Scheitholz. Sie behalten Ihr Heizbudget im Griff.

Die Crépito® Premium-Scheite stammen aus den besten Laubholzarten (Gruppe 1: Eiche, Buche, Hainbuche), bekannt für ihren hohen Heizwert, aus nachhaltig bewirtschafteten Wäldern der Region.

Der gleichmäßige Zuschnitt in kleine Querschnitte von höchstens 14 cm (Länge 25, 30 oder 40 cm) entspricht den technischen Vorgaben neuer Holzfeuerstätten und ermöglicht maximale Energieeffizienz. Das schont zugleich Ofen und Schornstein.

Die Trocknung auf unter 20 % Restfeuchte sichert einen optimalen Abbrand — gegenüber den rund 35 %, die im Handel für Holz der Qualität NF H2 nach einem Jahr Trocknung üblich sind.

Die Nebenprodukte der Fertigung werden zu 100 % verwertet und heizen das Produktionswerk.

Die Crépito® Premium-Scheite sind sauber und gleichmäßig, einfach zu handhaben und zu lagern.

TECHNISCHE DATEN
Scheitholz, gespalten und weitgehend entrindet
Herkunft: 100 % französisches Holz
Holzart: 100 % Hartlaubholz — Eiche, Hainbuche, Buche
Qualität: Gruppe H1 G1
Länge: 30 cm
Querschnitt: 8 cm ≤ 90 % Vol. ≤ 14 cm
Ascheanteil: ≤ 1,5 %
Heizwert (roh): 3,9 kWh/kg ≤ Hu ≤ 4,2 kWh/kg
Restfeuchte: 10 % ≤ H ≤ 20 % roh
Verhalten: schnelles Anzünden, sofortige Wärme
Leistung: garantierter Wirkungsgrad der Feuerstätte
Verwendung: sofort einsatzbereit',
        3334 => 'Holzart: 100 % Hartholz (Eiche, Hainbuche, Buche, Esche). Herkunft Frankreich. Heizwert: 2000 kWh je Raummeter.

Unsere Scheite von 25 cm bestehen aus trockenem Hartlaubholz — Eiche, Hainbuche, Buche, Esche —, den anerkannt besten Brennhölzern. Hartholz eignet sich besser für Dauerbrandöfen, weil seltener nachgelegt werden muss. Eiche, Buche, Esche und Hainbuche geben schöne Flammen und viel Glut, die lange nachglüht; ihre Dichte verlängert die Abstände zwischen den Ladungen. Gespalten und getrocknet bietet dieses Scheitholz einen außergewöhnlichen Heizwert bei sehr niedriger Restfeuchte (unter 20 %).

Trockenes Holz den ganzen Winter, lose geliefert
Unsere Scheite machen den Betrieb Ihrer Feuerstätte einfacher. Dank der niedrigen Restfeuchte (unter 20 %) erreichen Sie maximale Energieeffizienz, ohne den Aufwand von Lagerung und Zuschnitt. Unsere Scheite sind bereits gespalten, gebürstet und auf 25, 30, 40 oder 50 cm abgelängt. Über unser Vertriebsnetz liefern wir sie lose an — so haben Sie die ganze Heizperiode über trockenes Brennholz (Mischung aus Eiche, Hainbuche, Buche und Esche) in der benötigten Menge zur Hand.

Höchster Heizwert ohne Aufwand
Unsere Scheite sind sofort einsatzbereit. Direkt nach der Lieferung können Sie heizen und das Holzfeuer genießen: Das Holz ist bereits in kleine Abschnitte gespalten, abgelängt und getrocknet.

Wirtschaftlich und praktisch
Unsere Scheite senken den Verbrauch um 30 %. Sie verlängern außerdem die Lebensdauer von Ofen und Schornstein, denn extratrockenes Holz erzeugt zwei- bis dreimal weniger Asche und setzt die Anlage weniger zu — verglichen mit herkömmlichem Brennholz von rund 30 % Restfeuchte.',
        3335 => 'Holzart: 100 % Hartholz (Eiche, Hainbuche, Buche, Esche). Herkunft Frankreich. Heizwert: 2000 kWh je Raummeter.

Unsere Scheite von 40 cm bestehen aus trockenem Hartlaubholz — Eiche, Hainbuche, Buche, Esche —, den anerkannt besten Brennhölzern. Hartholz eignet sich besser für Dauerbrandöfen, weil seltener nachgelegt werden muss. Eiche, Buche, Esche und Hainbuche geben schöne Flammen und viel Glut, die lange nachglüht; ihre Dichte verlängert die Abstände zwischen den Ladungen. Gespalten und getrocknet bietet dieses Scheitholz einen außergewöhnlichen Heizwert bei sehr niedriger Restfeuchte (unter 20 %).

Trockenes Holz den ganzen Winter, lose geliefert
Unsere Scheite machen den Betrieb Ihrer Feuerstätte einfacher. Dank der niedrigen Restfeuchte (unter 20 %) erreichen Sie maximale Energieeffizienz, ohne den Aufwand von Lagerung und Zuschnitt. Unsere Scheite sind bereits gespalten, gebürstet und auf 25, 30, 40 oder 50 cm abgelängt. Über unser Vertriebsnetz liefern wir sie lose an — so haben Sie die ganze Heizperiode über trockenes Brennholz (Mischung aus Eiche, Hainbuche, Buche und Esche) in der benötigten Menge zur Hand.

Höchster Heizwert ohne Aufwand
Unsere Scheite sind sofort einsatzbereit. Direkt nach der Lieferung können Sie heizen und das Holzfeuer genießen: Das Holz ist bereits in kleine Abschnitte gespalten, abgelängt und getrocknet.

Wirtschaftlich und praktisch
Unsere Scheite senken den Verbrauch um 30 %. Sie verlängern außerdem die Lebensdauer von Ofen und Schornstein, denn extratrockenes Holz erzeugt zwei- bis dreimal weniger Asche und setzt die Anlage weniger zu — verglichen mit herkömmlichem Brennholz von rund 30 % Restfeuchte.',
        3336 => 'Holzart: 100 % Hartholz (Eiche, Hainbuche, Buche, Esche). Herkunft Frankreich. Heizwert: 2000 kWh je Raummeter.

Unsere Scheite von 50 cm bestehen aus trockenem Hartlaubholz — Eiche, Hainbuche, Buche, Esche —, den anerkannt besten Brennhölzern. Hartholz eignet sich besser für Dauerbrandöfen, weil seltener nachgelegt werden muss. Eiche, Buche, Esche und Hainbuche geben schöne Flammen und viel Glut, die lange nachglüht; ihre Dichte verlängert die Abstände zwischen den Ladungen. Gespalten und getrocknet bietet dieses Scheitholz einen außergewöhnlichen Heizwert bei sehr niedriger Restfeuchte (unter 20 %).

Trockenes Holz den ganzen Winter, lose geliefert
Unsere Scheite machen den Betrieb Ihrer Feuerstätte einfacher. Dank der niedrigen Restfeuchte (unter 20 %) erreichen Sie maximale Energieeffizienz, ohne den Aufwand von Lagerung und Zuschnitt. Unsere Scheite sind bereits gespalten, gebürstet und auf 25, 30, 40 oder 50 cm abgelängt. Über unser Vertriebsnetz liefern wir sie lose an — so haben Sie die ganze Heizperiode über trockenes Brennholz (Mischung aus Eiche, Hainbuche, Buche und Esche) in der benötigten Menge zur Hand.

Höchster Heizwert ohne Aufwand
Unsere Scheite sind sofort einsatzbereit. Direkt nach der Lieferung können Sie heizen und das Holzfeuer genießen: Das Holz ist bereits in kleine Abschnitte gespalten, abgelängt und getrocknet.

Wirtschaftlich und praktisch
Unsere Scheite senken den Verbrauch um 30 %. Sie verlängern außerdem die Lebensdauer von Ofen und Schornstein, denn extratrockenes Holz erzeugt zwei- bis dreimal weniger Asche und setzt die Anlage weniger zu — verglichen mit herkömmlichem Brennholz von rund 30 % Restfeuchte.',
        3337 => 'Eiche eignet sich für Kaminöfen, Holzherde, Holzbacköfen, Räucheröfen und offene Kamine. Sofort brennfertig, denn diese Eichenscheite sind kammergetrocknet.

Handliches Scheitmaß: Jedes Scheit ist 25 cm lang. Ein Netz enthält üblicherweise eine Auswahl an Stärken von 4 bis 14 cm.

Eiche ist dicht und hält länger vor als Birke, Nadelholz, Kiefer, Esche oder Erle.

Zuverlässig niedrige Restfeuchte: Außen liegt sie stets bei höchstens 20 % — das Holz ist also brennfertig. Kammergetrocknete Eiche spart Ihnen die Wartezeit.

Kammergetrocknetes Brennholz: Unser gesamtes Scheitholz stammt aus FSC-zertifizierten Quellen, also aus nachhaltiger Forstwirtschaft. Ebenso geeignet zum Räuchern am Grill.

Gleichbleibendes Netzmaß: Die Netze haben jedes Mal dieselbe Größe.',
        3342 => 'Erlenholz ist ein günstiges Brennholz und trotz seines raschen Abbrands eine gute Wahl. Es gibt beim Verbrennen eine sehr lebhafte Wärme ab. Im Baskenland wurde die Erle im Juli geschlagen, abgelängt und zu Scheiten gespalten. Die sehr kurze Trockenzeit erlaubte es, sie zur Heizperiode mit höchstem Energieertrag einzusetzen. Erlenholz wird auch für Öfen verwendet, die schnell auf hohe Temperatur kommen müssen — Bäckerei, Pizzeria, Schmiede und dergleichen.',
        3344 => 'Extratrocken (mindestens 18 Monate) stammen die Weißeichenscheite aus nachhaltig bewirtschafteten französischen Wäldern der Franche-Comté, der Vogesen und des Juras. Weißeiche ist ein dichtes Holz, das im Gebrauch eine schöne Glut bildet. Sie verbrennt gleichmäßig und liefert einen hohen Heizwert. Weißeichen-Brennholz raucht wenig, brennt langsam ab und verschmutzt Ihre Feuerstätte kaum.',
        3348 => 'Brennholzkiste Birke ultratrocken (2 m³)

Wir verkaufen ausschließlich nachhaltiges Holz mit nachgewiesener Qualität und Ausbeute.

BIRKE
Birkenholz, kenntlich an der weißen Rinde, zählt zu den weicheren Hölzern und passt damit zu kleineren Öfen. Es lässt sich leicht anzünden, gibt rasch Wärme ab und brennt mit schönem Flammenbild.

Eigenschaften von Birkenholz
Weichholzart
Besonders geeignet für kleine Öfen und Kamine
Entzündet sich leicht und schnell
Schönes Flammenspiel
Sie legen 2 bis 3 Scheite auf einmal auf',
        3361 => 'Palette Kohle 100 % Anthrazit (A12–22 mm)

Diese Kohlesorten haben wir stets in 25-kg-Säcken vorrätig. Lieferbar in der Körnung 12–22 mm, direkt zu Ihnen nach Hause.

Die Hartkohle mit dem höchsten Energiegehalt. Diese etwas härtere Kohle gibt wenig Asche und viel Wärme. Eine schön glänzende Kohle, die praktisch nicht staubt. Bestens geeignet für Kohleöfen, Brenner und Kamineinsätze.

Eigenschaften der Kohle 100 % Anthrazit (A12–22 mm)
Anthrazit für Kohleöfen mit Fülltrichter
Körnung: 12–22 mm
Flüchtige Bestandteile: 7–24 %
40 Säcke à 25 kg',
        3532 => 'Premium-Pellets mit zu 100 % natürlichem Zusatz und einer Schüttdichte über 630 kg/m³: Je dichter das Pellet, desto weniger bricht es in der Förderschnecke und desto weniger Feinanteil entsteht. Genau daran unterscheidet sich ein Premium-Pellet von einem Standardpellet.

Unter 8 % Restfeuchte und mindestens 4,8 kWh/kg: Die Sichtscheibe bleibt länger sauber und der Aschekasten muss seltener geleert werden. Über eine Heizperiode gerechnet ist das ebenso gewonnene Zeit wie gesparte Säcke.

100 % Nadelholz. Heizwert Hu ≥ 4,8 kWh/kg. Restfeuchte ≤ 8 %, Asche 0,5 %, Feinanteil ≤ 0,5 %. Schüttdichte ≥ 630 kg/m³. Zusatz zu 100 % natürlich, ≤ 0,8 %. Palette mit 66 Sack à 15 kg, insgesamt 990 kg. Für Pelletofen, Kamineinsatz oder Heizkessel.',
        3537 => 'DIN PELLETS Holzpellets, zertifiziert nach DIN Plus und aus 100 % Nadelholz. Hergestellt in Nordfrankreich — ein regionales Produkt von hoher Qualität.

Gebinde: Palette.',
        3538 => 'Hochwertige Holzpellets für Ihren Pelletofen. Unsere Holzpellets tragen selbstverständlich die Zertifizierung EN plus A1.

Kennwerte unserer Holzpellets:
Durchmesser 6,3 mm
Länge 16,5 mm
Restfeuchte 9,2 %
Asche 0 %
Heizwert 16,7 MJ/kg
Stickstoff 0 %
Schwefel 0,015 %
Chlor 0,026 %
Arsen < 0 mg/kg
Cadmium 0 mg/kg
Chrom 8,36 mg/kg
Kupfer 8,83 mg/kg
Blei 5,58 mg/kg
Quecksilber 0 mg/kg
Nickel 0 mg/kg
Zink 18,26 mg/kg',
        3543 => 'Hergestellt im selben Sägewerk, das die Sägespäne liefert: Der kurze Weg hält das Material frisch, und die Niedertemperaturtrocknung im Bandtrockner verbrennt es nicht. Daraus ergeben sich ein niedriger Ascheanteil und ein hoher Ascheschmelzpunkt — mit anderen Worten: keine Schlacke im Brennertopf.

Gesiebt wird unmittelbar vor dem Abfüllen jedes Sacks. Dieses Detail erklärt den sehr geringen Staubanteil beim Öffnen und damit eine Förderschnecke, die nicht verklebt.

Zertifiziert nach DIN Plus und EN Plus A1. Hochdruckverpressung.',
        3544 => 'Die BIOSYL Premium 5.0 Holzpellets sind sorgfältig verpackt und brauchen wenig Lagerfläche. Nach Anlieferung der Palette sollten Sie sie dennoch trocken, geschützt und belüftet lagern, damit sie nichts von ihrem Heizwert verlieren.

Halten Sie die Pellets bei der Lagerung von Flammen und Wärmequellen fern. Ebenso wichtig ist es, Feuchtigkeit zu vermeiden: Ein feucht gewordenes Pellet zerfällt und verstopft die Förderschnecke.',
        3547 => 'Das VALBOVAL Pellet gehört zu unseren Spitzenprodukten; seine Qualität übertrifft die Anforderungen der Norm DIN Plus. Dank des geringen Asche- und Staubanteils setzen sich Ofen, Kamineinsatz oder Heizkessel kaum zu.

Der hohe Heizwert von 5 kWh/kg sorgt für gleichmäßige Wärme im Raum und einen schnellen Temperaturanstieg. Geeignet für alle Pelletheizsysteme.',
        3548 => 'Das NATURKRAFT Pellet ist ein Produkt von guter Qualität mit doppelter Zertifizierung nach DIN Plus (deutsche Norm) und ENplus (europäische Norm). Dieses Holzpellet eignet sich für alle Ofentypen. Dank seiner Kennwerte müssen Sie den Ofen seltener reinigen, und die Sichtscheibe bleibt frei von Ruß.',
        3549 => 'Ein französisches Nadelholzpellet mit über 4,6 kWh/kg: Die Wärme bleibt gleichmäßig und der Ofen verschmutzt dank des geringen Asche- und Staubanteils kaum.

Der Sack für alle, die Premiumqualität wollen, ohne den Preis der bekanntesten Marken zu zahlen — und dank der Produktion im Inland ist der Transportweg kurz.

100 % naturbelassenes Nadelholz. Heizwert über 4,6 kWh/kg. Geringer Asche- und Staubanteil. Palette mit 65 Sack à 15 kg, insgesamt 975 kg. Französische Produktion.',
        3551 => 'Pellets aus dem Sägewerk des Herstellers, also aus frischen und gleichbleibenden Spänen: Das erklärt den Staubanteil unter 0,4 % und dass der Ofen kaum verschmutzt. Über eine ganze Heizperiode sieht man den Unterschied im Aschekasten.

Unter 8 % Restfeuchte und 4,6 bis 5 kWh/kg: Der Abbrand ist langsam und vollständig, für dieselbe Wärme braucht es weniger Säcke. Das beste Preis-Leistungs-Verhältnis im Pelletsortiment.

100 % Nadelholz, Durchmesser 6 mm. Zertifiziert nach DIN Plus und PEFC. Heizwert 4,6 bis 5 kWh/kg. Restfeuchte unter 8 %.',
        3573 => 'Sehr robuste Kunststoffsäcke. Holzpaletten ohne Pfand und ausreichend breit, sodass die Säcke nicht überstehen und nicht aufreißen. Palette mit Schutzhaube gegen Regen.',
        3578 => 'Holzpellets wählt man meist, um wirtschaftlich zu heizen. Diese Pellets stammen aus den Benelux-Ländern und sind doppelt zertifiziert nach DIN Plus und EN Plus — ein Qualitätsnachweis.

Die Kennwerte liegen im Marktstandard: 0,7 % Asche und 0,5 % Feinanteil.

Technische Daten
Zusammensetzung: Nadel- und Laubholz
Zertifikate: DIN Plus, EN Plus A1
Heizwert: über 4,6 kWh/kg
Ascheanteil: 0,7 %
Feinanteil: 0,5 %',
        3579 => 'Origine : 100 % bois vierge Dimensions : 3,15 mm Quantité : 15 kg par sac Unité de vente : 72 sacs par palette Les granulés de bois Crépito® Pellets Premium sont 100 % naturels et issus de la valorisation des co-produits de l\'industrie du bois. Leur fabrication est garantie sans additif, ni liant ajouté. Les granulés de bois Crépito® offrent d\'excellentes performances calorifiques obtenues grâce à un contrôle qualité en temps réel du process, et des outils de fabrication, garantissant ainsi un rendement maximal des appareils de chauffage aux granulés.',
        3580 => 'Scheitlänge: 40 cm. Durchmesser Rauchrohranschluss: 150 mm. Wirkungsgrad: 84 %.',
        3582 => 'Ein Feuerraum aus Guss, nicht aus Stahl: Guss wird langsamer warm, gibt die Wärme dafür noch lange ab, wenn das Feuer schon heruntergebrannt ist. Deshalb ist der Raum am frühen Morgen noch mild.

Elf Kilowatt und Scheite bis 65 cm: Der Ofen heizt einen großen Raum oder ein offenes Erdgeschoss und nimmt die üblichen Handelslängen an, ohne dass nachgesägt werden muss. Beschickt wird von vorn oder von der Seite, je nachdem, wie viel Platz ringsum ist.

Leistung 11 kW, Wirkungsgrad 76,2 %. Scheite bis 65 cm.',
        3587 => 'Vier Tonnen Holzbriketts: eine Bestellung für die ganze Saison, für ein Haus, das vollständig mit Holz geheizt wird. In dieser Menge hat der Kilopreis nichts mehr mit dem Sackeinkauf zu tun.

Bei 10 % Restfeuchte und 5000 kWh je Tonne brennen sie lange und sauber, mit nur 1,5 % Asche. Sie lassen sich viermal dichter stapeln als herkömmliche Scheite — vier Paletten passen in eine Garage.

Gepresstes Nadelholz. Länge 27 cm, Durchmesser 8,5 cm. Restfeuchte 10 %, Heizwert 5000 kWh/t.',
        3661 => 'Trockenes, gespaltenes Holz in der Box geliefert: das, was noch am selben Abend brennt. Die 50 cm passen zu offenen Kaminen und großen Kamineinsätzen; für einen Ofen sind die kurzen Längen die bessere Wahl.

Ein Hinweis, der Missverständnisse erspart: Ein Raummeter Scheite zu 50 cm nimmt gestapelt rund 0,80 m³ ein, zu 33 cm nur 0,60 m³. Kurzes Holz stapelt sich enger, das sichtbare Volumen sinkt — die Holzmenge bleibt dieselbe. Vergleichen Sie also Raummeter, nicht Kubikmeter.

Laubholzmischung: Eiche, Buche, Esche, Edelkastanie. Länge 50 cm.',
        3663 => 'Das kleine Paket für das Wochenende — oder um auszuprobieren, ob diese Scheite zur eigenen Feuerstätte passen, bevor man einen ganzen Raummeter bestellt. Brennfertig: Sie zünden schnell und geben sofort Wärme, ohne das Zischen von noch feuchtem Holz.

Es ist eine Hartholzmischung, die Scheite sehen daher von Paket zu Paket nicht gleich aus — Aussehen und Stärke schwanken, die Heizqualität nicht.',
    ];
}
