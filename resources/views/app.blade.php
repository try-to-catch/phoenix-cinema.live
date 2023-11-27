<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description"
        charset="Фенікс - популярна мережа кінотеатрів. Фенікс - це відмінний сервіс та задоволені клієнти. Обирайте та бронюйте квитки на понад 100 популярних фільмів прямо зараз">

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link rel="icon" type="image/svg+xml" href="/favicon.svg"/>
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

  <!-- Scripts -->
  @routes
  @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>
