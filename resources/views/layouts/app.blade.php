<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PEP.uno') }} - Penser plus clair, agir plus vite</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J0V7BGS2GB"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-J0V7BGS2GB');
    </script>
</head>
<body class="bg-pep-bg text-pep-dark antialiased">
    
    <!-- Navigation Flottante -->
    <nav class="fixed w-full z-50 top-0 left-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between glass mt-4 rounded-full mx-4 lg:mx-auto">
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" class="flex items-center group">
                    <img src="https://bruno.appliscreaweb.fr/public/Logos/logo_pep_uno.webp" alt="PEP.uno Logo" class="h-10 transition-transform transform group-hover:scale-105">
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-xs font-bold uppercase tracking-widest">
                <a href="{{ url('/') }}" class="hover:text-pep-accent transition-colors">Accueil</a>
                <a href="{{ url('/faq') }}" class="hover:text-pep-accent transition-colors">FAQ</a>
                <a href="{{ route('blog.index') }}" class="hover:text-pep-accent transition-colors">Articles</a>
                <a href="{{ route('quiz.index') }}" class="text-blue-600 font-extrabold flex items-center gap-1 hover:text-pep-accent transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Le défi
                </a>
                <a href="https://pep.world/" target="_blank" class="hover:text-pep-accent transition-colors">Méthode PEP</a>
                <a href="{{ url('/admin/login') }}" class="bg-pep-dark text-white px-5 py-2.5 rounded-full hover:bg-pep-accent transition-all">
                    S'abonner
                </a>
            </div>

            <!-- Mobile Menu Trigger (Simple) -->
            <button class="md:hidden p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </nav>

    @yield('content')

    <script>
        // Effet au scroll pour la nav
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('px-2', 'py-1');
            } else {
                nav.classList.remove('px-2', 'py-1');
            }
        });
    </script>
</body>
</html>
