<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>
<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
<!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css' rel='stylesheet' />

<!-- Google tag (gtag.js) -->
 <!-- END Google tag (gtag.js) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Etiquetas meta para SEO -->
    <meta name="keywords"
        content="hotel, Cebreros, España, alojamiento,alojamiento en cebreros, habitaciones, restaurante, cocina local, actividades, reserva">
<!-- Etiqueta meta para robots de búsqueda -->
    <meta name="robots" content="index, follow">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href={{ asset("img/favicon.png") }} />
</head>