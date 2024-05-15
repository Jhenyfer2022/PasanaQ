<!DOCTYPE html>
<html>
<head>
    <title>Invitación al juego</title>
</head>
<body>
    <h1>¡Te invitamos a participar en el juego de pasanaku: {{ $juego->nombre }}!</h1>
    <p>Para poder jugar descarga nuestra apk mediante el siguiente QR:</p>
    <img src="{{ $imageUrl }}" alt="Pasanku">
</body>
</html>