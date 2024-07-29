<!DOCTYPE html>
<html>
<head>
    <title>Your Booking Code</title>
</head>
<body>
<h1>Hello, {{ $userName }}</h1>

<p>Thank you for booking with us. Here is your unique booking code:</p>

<div style="border: 1px solid #ccc; padding: 10px; margin: 20px 0;">
    <strong>{{ $code }}</strong>
</div>

<p>Please present this code to your host to validate your reservation.</p>

<p>Your reservation is scheduled for:</p>

<div style="border: 1px solid #ccc; padding: 10px; margin: 20px 0;">
    <strong>{{ $reservationDate}}</strong>
</div>

<p>Thank you,<br>
    {{ config('app.name') }}</p>
</body>
</html>
