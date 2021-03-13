<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    @include('head')
    <title>Room 911 Access Control</title>
</head>
<body>
    <h1>Muestro usuarios</h1>
    @foreach ($users as $user)
        <p>This is user {{ $user->id }}</p>
    @endforeach
</body>
</html>