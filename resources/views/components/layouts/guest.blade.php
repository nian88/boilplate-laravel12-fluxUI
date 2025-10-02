<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @fluxAppearance
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body class="min-h-screen bg-white dark:bg-zinc-900 antialiased">
{{ $slot }}
@fluxScripts
</body>
</html>