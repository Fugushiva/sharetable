<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-gray-100 text-gray-800">
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4">Bonjour {{$user->firstname}} {{$user->lastname}},</h1>
    <p class="mb-4">Vous avez effectué un paiement de <span class="font-semibold">{{$annonce->price}}€</span> pour la commande.</p>
    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">Information relative à la commande:</h2>
        <p class="mb-2">Informations relatives à l'hôte:</p>
        <p class="ml-4">
            <span class="font-medium">Nom:</span> {{$host->user->firstname}} {{$host->user->lastname}}
        </p>
    </div>
</div>
</body>
</html>
