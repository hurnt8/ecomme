<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $messageSubject }}</title>
</head>
<body style="font-family: Arial, sans-serif; color:#222; max-width:600px; margin:0 auto;">
    <h1 style="font-size:18px;">Nouveau message de contact</h1>
    <p>
        De : {{ $senderName }} &lt;{{ $senderEmail }}&gt;<br>
        Sujet : {{ $messageSubject }}
    </p>
    <div style="white-space:pre-line; border-top:1px solid #ddd; padding-top:12px; margin-top:12px;">{{ $body }}</div>
</body>
</html>
