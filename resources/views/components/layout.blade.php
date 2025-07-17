<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mini-Blog') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/commeownity-icon.svg') }}">

    <!-- Include Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Include Google Fonts: Geist -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css"
    />

    <!-- Tailwind Config Override for Custom Fonts -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        geist: ['Geist'],
                    }
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Geist'; }
    </style>
</head>

<body>
    @include('components.navbar')

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    @include('components.footer')

</body>
</html>