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
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-center text-indigo-600">Bienvenue {{$user->firstname}} !</h1>
        <p class="text-gray-600 mb-6 text-center">Merci de vous être inscrit(e) sur ShareTable ! Nous sommes ravis de vous accueillir parmi nous.</p>
        <div class="bg-gray-100 p-4 rounded-lg mb-4">
            <h2 class="text-xl font-semibold mb-2">Informations d'inscription :</h2>
            <p><span class="font-bold">Nom :</span> {{$user->firstname}} {{$user->lastname}}</p>
            <p><span class="font-bold">Email :</span> {{$user->email}}</p>
        </div>
        <p class="text-gray-600 text-center">Nous vous remercions pour votre confiance et espérons que vous apprécierez votre expérience sur ShareTable.</p>
        <div class="text-center mt-6">
            <a href="#" class="inline-block bg-indigo-600 text-white py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition">Explorer ShareTable</a>
        </div>
        <p class="text-gray-500 text-center mt-6">Cordialement,</p>
        <p class="text-gray-500 text-center">L'équipe de ShareTable</p>
    </div>
</div>
</body>
</html>
