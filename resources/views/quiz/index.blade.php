<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diagnostic - Le Défi PEP</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans flex flex-col items-center min-h-screen">
    
    <!-- Header Compact Immersif -->
    <header class="w-full bg-white border-b border-slate-100 py-3 px-6 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-[#00B5AD] rounded-md flex items-center justify-center text-white font-bold text-xs shadow-sm">P</div>
            <span class="font-bold tracking-tighter text-lg uppercase italic text-slate-800">pep<span class="text-[#00B5AD]">.uno</span></span>
        </div>
        <div class="flex items-center gap-4">
           <span class="hidden sm:inline text-[10px] font-bold text-slate-400 tracking-widest uppercase">Expertise Mode</span>
           <div class="hidden sm:block h-4 w-px bg-slate-200"></div>
           <a href="{{ route('home') }}" class="text-[10px] font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest flex items-center gap-1 transition-colors">
               Quitter
           </a>
        </div>
    </header>

    @if(isset($activeQuiz) && $activeQuiz->questions->count() > 0)
        <!-- Le vrai Quiz Component -->
        @include('components.home.quiz-section')
    @else
        <!-- Remplacement vide -->
        <main class="flex-1 w-full max-w-4xl flex flex-col justify-center items-center p-6 md:p-12">
            <div class="w-full max-w-lg mx-auto bg-white p-10 rounded-3xl shadow-xl border border-slate-100 text-center">
                <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6 italic">Aucun Diagnostic Actif</h2>
                <p class="text-slate-500 mb-8">Revenez plus tard pour tester vos réflexes.</p>
                <a href="{{ route('home') }}" class="bg-[#00B5AD] text-white px-8 py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-[#00B5AD]/30 transition-all focus:outline-none">Fermer</a>
            </div>
        </main>
    @endif

</body>
</html>
