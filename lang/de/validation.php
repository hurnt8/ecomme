<?php

/*
 * German validation messages.
 *
 * Covers the rules this application actually uses (required, email, max, min, unique, confirmed,
 * numeric, integer, boolean, in, exists, image, dimensions, date, string, regex) plus the common
 * ones a form may hit. Anything not listed falls back to Laravel's own key name, which is ugly
 * but visible — better than a silently English message on a German page.
 */

return [
    'accepted' => 'Das Feld :attribute muss akzeptiert werden.',
    'active_url' => 'Das Feld :attribute ist keine gültige Internet-Adresse.',
    'after' => 'Das Feld :attribute muss ein Datum nach :date sein.',
    'after_or_equal' => 'Das Feld :attribute muss ein Datum nach oder gleich :date sein.',
    'alpha' => 'Das Feld :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das Feld :attribute darf nur aus Buchstaben, Zahlen, Binde- und Unterstrichen bestehen.',
    'alpha_num' => 'Das Feld :attribute darf nur aus Buchstaben und Zahlen bestehen.',
    'array' => 'Das Feld :attribute muss ein Array sein.',
    'before' => 'Das Feld :attribute muss ein Datum vor :date sein.',
    'before_or_equal' => 'Das Feld :attribute muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'numeric' => 'Das Feld :attribute muss zwischen :min & :max liegen.',
        'file' => 'Das Feld :attribute muss zwischen :min & :max Kilobytes groß sein.',
        'string' => 'Das Feld :attribute muss zwischen :min & :max Zeichen lang sein.',
        'array' => 'Das Feld :attribute muss zwischen :min & :max Elemente haben.',
    ],
    'boolean' => 'Das Feld :attribute muss entweder "true" oder "false" sein.',
    'confirmed' => 'Die Bestätigung für das Feld :attribute stimmt nicht überein.',
    'date' => 'Das Feld :attribute muss ein gültiges Datum sein.',
    'date_equals' => 'Das Feld :attribute muss ein Datum gleich :date sein.',
    'date_format' => 'Das Feld :attribute entspricht nicht dem Format :format.',
    'different' => 'Die Felder :attribute und :other müssen sich unterscheiden.',
    'digits' => 'Das Feld :attribute muss :digits Stellen haben.',
    'digits_between' => 'Das Feld :attribute muss zwischen :min und :max Stellen haben.',
    'dimensions' => 'Das Feld :attribute hat ungültige Bildabmessungen.',
    'distinct' => 'Das Feld :attribute beinhaltet einen bereits vorhandenen Wert.',
    'email' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das Feld :attribute muss mit einem der folgenden Werte enden: :values.',
    'exists' => 'Der gewählte Wert für :attribute ist ungültig.',
    'file' => 'Das Feld :attribute muss eine Datei sein.',
    'filled' => 'Das Feld :attribute muss ausgefüllt sein.',
    'gt' => [
        'numeric' => 'Das Feld :attribute muss größer als :value sein.',
        'file' => 'Das Feld :attribute muss größer als :value Kilobytes sein.',
        'string' => 'Das Feld :attribute muss länger als :value Zeichen sein.',
        'array' => 'Das Feld :attribute muss mehr als :value Elemente haben.',
    ],
    'gte' => [
        'numeric' => 'Das Feld :attribute muss größer oder gleich :value sein.',
        'file' => 'Das Feld :attribute muss größer oder gleich :value Kilobytes sein.',
        'string' => 'Das Feld :attribute muss mindestens :value Zeichen lang sein.',
        'array' => 'Das Feld :attribute muss mindestens :value Elemente haben.',
    ],
    'image' => 'Das Feld :attribute muss ein Bild sein.',
    'in' => 'Der gewählte Wert für :attribute ist ungültig.',
    'in_array' => 'Das Feld :attribute existiert nicht in :other.',
    'integer' => 'Das Feld :attribute muss eine ganze Zahl sein.',
    'ip' => 'Das Feld :attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das Feld :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das Feld :attribute muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das Feld :attribute muss ein gültiger JSON-String sein.',
    'lt' => [
        'numeric' => 'Das Feld :attribute muss kleiner als :value sein.',
        'file' => 'Das Feld :attribute muss kleiner als :value Kilobytes sein.',
        'string' => 'Das Feld :attribute muss kürzer als :value Zeichen sein.',
        'array' => 'Das Feld :attribute muss weniger als :value Elemente haben.',
    ],
    'lte' => [
        'numeric' => 'Das Feld :attribute muss kleiner oder gleich :value sein.',
        'file' => 'Das Feld :attribute muss kleiner oder gleich :value Kilobytes sein.',
        'string' => 'Das Feld :attribute darf maximal :value Zeichen lang sein.',
        'array' => 'Das Feld :attribute darf maximal :value Elemente haben.',
    ],
    'max' => [
        'numeric' => 'Das Feld :attribute darf maximal :max sein.',
        'file' => 'Das Feld :attribute darf maximal :max Kilobytes groß sein.',
        'string' => 'Das Feld :attribute darf maximal :max Zeichen haben.',
        'array' => 'Das Feld :attribute darf maximal :max Elemente haben.',
    ],
    'mimes' => 'Das Feld :attribute muss den Dateityp :values haben.',
    'mimetypes' => 'Das Feld :attribute muss den Dateityp :values haben.',
    'min' => [
        'numeric' => 'Das Feld :attribute muss mindestens :min sein.',
        'file' => 'Das Feld :attribute muss mindestens :min Kilobytes groß sein.',
        'string' => 'Das Feld :attribute muss mindestens :min Zeichen lang sein.',
        'array' => 'Das Feld :attribute muss mindestens :min Elemente haben.',
    ],
    'not_in' => 'Der gewählte Wert für :attribute ist ungültig.',
    'not_regex' => 'Das Format des Feldes :attribute ist ungültig.',
    'numeric' => 'Das Feld :attribute muss eine Zahl sein.',
    'password' => 'Das Passwort ist falsch.',
    'present' => 'Das Feld :attribute muss vorhanden sein.',
    'regex' => 'Das Format des Feldes :attribute ist ungültig.',
    'required' => 'Das Feld :attribute muss ausgefüllt werden.',
    'required_if' => 'Das Feld :attribute muss ausgefüllt werden, wenn :other den Wert :value hat.',
    'required_unless' => 'Das Feld :attribute muss ausgefüllt werden, wenn :other nicht den Wert :values hat.',
    'required_with' => 'Das Feld :attribute muss ausgefüllt werden, wenn :values ausgefüllt wurde.',
    'required_with_all' => 'Das Feld :attribute muss ausgefüllt werden, wenn :values ausgefüllt wurde.',
    'required_without' => 'Das Feld :attribute muss ausgefüllt werden, wenn :values nicht ausgefüllt wurde.',
    'required_without_all' => 'Das Feld :attribute muss ausgefüllt werden, wenn keines der Felder :values ausgefüllt wurde.',
    'same' => 'Die Felder :attribute und :other müssen übereinstimmen.',
    'size' => [
        'numeric' => 'Das Feld :attribute muss gleich :size sein.',
        'file' => 'Das Feld :attribute muss :size Kilobytes groß sein.',
        'string' => 'Das Feld :attribute muss :size Zeichen lang sein.',
        'array' => 'Das Feld :attribute muss :size Elemente haben.',
    ],
    'starts_with' => 'Das Feld :attribute muss mit einem der folgenden Werte beginnen: :values.',
    'string' => 'Das Feld :attribute muss ein String sein.',
    'timezone' => 'Das Feld :attribute muss eine gültige Zeitzone sein.',
    'unique' => 'Der Wert im Feld :attribute ist bereits vergeben.',
    'uploaded' => 'Das Feld :attribute konnte nicht hochgeladen werden.',
    'url' => 'Das Format der :attribute ist ungültig.',
    'uuid' => 'Das Feld :attribute muss ein UUID sein.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
     * Field names as a shopper reads them, so "Das Feld customer_email muss ausgefüllt werden"
     * never reaches a customer.
     */
    'attributes' => [
        'customer_name' => 'Name',
        'customer_email' => 'E-Mail-Adresse',
        'address_line1' => 'Adresse',
        'postal_code' => 'Postleitzahl',
        'city' => 'Ort',
        'country' => 'Land',
        'email' => 'E-Mail-Adresse',
        'password' => 'Passwort',
        'password_confirmation' => 'Passwortbestätigung',
        'current_password' => 'Aktuelles Passwort',
        'name' => 'Name',
        'subject' => 'Betreff',
        'message' => 'Nachricht',
        'quantity' => 'Menge',
        'order_number' => 'Bestellnummer',
    ],
];
