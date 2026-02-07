<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>{{ $title ?? trim($__env->yieldContent('title', 'Sistema')) }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

  {{-- Icons --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  {{-- (Opcional) FullCalendar CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />

  {{-- Tu CSS legacy: ojo, puede pisar Tailwind si trae estilos globales fuertes --}}
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />

  {{-- Vite (Tailwind + JS) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>