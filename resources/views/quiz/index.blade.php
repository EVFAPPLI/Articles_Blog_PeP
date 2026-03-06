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


    <!-- Animation SVG du Formateur PEP -->
    <style>
        @keyframes pulseRing {
            0% { transform: scale(0.95); opacity: 0.4; }
            50% { transform: scale(1.1); opacity: 0.1; }
            100% { transform: scale(0.95); opacity: 0.4; }
        }
        .pulse-ring {
            animation: pulseRing 5s ease-in-out infinite;
            transform-origin: center;
        }

        @keyframes rightArmMove {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(-8deg); }
        }
        .instructor-arm-right {
            transform-origin: 535px 230px;
            animation: rightArmMove 4s ease-in-out infinite;
        }

        @keyframes leftArmMove {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(5deg); }
        }
        .instructor-arm-left {
            transform-origin: 465px 230px;
            animation: leftArmMove 4s ease-in-out infinite;
        }

        @keyframes floatItem {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(3deg); }
        }
        .quiz-element {
            animation: floatItem 6s ease-in-out infinite;
        }

        @keyframes flowWave {
            0% { stroke-dashoffset: 800; }
            100% { stroke-dashoffset: 0; }
        }
        .animate-flow {
            stroke-dasharray: 800;
            animation: flowWave 12s linear infinite;
        }

        .svg-container svg {
            width: 100%;
            height: auto;
            border-radius: 40px;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.1);
            background: white;
            display: block;
        }
    </style>

    <div class="w-full max-w-4xl mx-auto px-6 mb-16 svg-container relative z-10">
        <svg viewBox="0 0 1000 520" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="pepGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#6366f1" />
                    <stop offset="50%" style="stop-color:#a855f7" />
                    <stop offset="100%" style="stop-color:#ec4899" />
                </linearGradient>
                <filter id="softShadow">
                    <feDropShadow dx="0" dy="8" stdDeviation="12" flood-opacity="0.08"/>
                </filter>
            </defs>

            <!-- Arrière-plan Studio -->
            <rect width="1000" height="520" fill="#ffffff" />
            <circle class="pulse-ring" cx="500" cy="240" r="220" fill="none" stroke="url(#pepGrad)" stroke-width="1" opacity="0.15" />
            
            <!-- Éléments de Quiz Flottants -->
            <g class="quiz-element" style="animation-delay: 0.2s">
                <rect x="780" y="80" width="100" height="100" rx="30" fill="white" filter="url(#softShadow)" />
                <path d="M822 130 L828 136 L838 124" fill="none" stroke="#8b5cf6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </g>

            <g class="quiz-element" style="animation-delay: 2.5s">
                <rect x="120" y="320" width="100" height="100" rx="30" fill="white" filter="url(#softShadow)" />
                <text x="170" y="385" text-anchor="middle" font-size="50" font-weight="900" fill="url(#pepGrad)" font-family="sans-serif">?</text>
            </g>

            <!-- LE FORMATEUR (Design d'expert, Symétrique) -->
            <g transform="translate(0, 40)">
                <!-- Buste / Torse -->
                <path d="M440 380 L560 380 L560 220 C 560 190 535 170 500 170 C 465 170 440 190 440 220 Z" fill="#1e293b" />
                
                <!-- Détail du Col -->
                <path d="M485 170 L500 195 L515 170" fill="none" stroke="white" stroke-width="2" opacity="0.2" />

                <!-- Bras Gauche avec Tablette -->
                <g class="instructor-arm-left">
                    <path d="M450 220 L 400 300" stroke="#1e293b" stroke-width="22" stroke-linecap="round" />
                    <g transform="translate(365, 275) rotate(-10)">
                        <rect width="70" height="90" rx="12" fill="#0f172a" stroke="#475569" stroke-width="2" />
                        <rect x="15" y="15" width="40" height="4" rx="2" fill="url(#pepGrad)" />
                        <rect x="15" y="25" width="25" height="2" rx="1" fill="#475569" />
                    </g>
                </g>
                
                <!-- Bras Droit (Geste de présentation) -->
                <g class="instructor-arm-right">
                    <path d="M550 220 L 620 280" stroke="#1e293b" stroke-width="22" stroke-linecap="round" />
                    <circle cx="620" cy="280" r="11" fill="#1e293b" />
                </g>

                <!-- Tête -->
                <circle cx="500" cy="110" r="45" fill="#1e293b" />
            </g>

            <!-- Dashboard de progression -->
            <g transform="translate(630, 220)">
                <rect x="0" y="0" width="260" height="160" rx="32" fill="white" filter="url(#softShadow)" />
                <text x="30" y="45" fill="#94a3b8" font-size="10" font-weight="800" font-family="sans-serif">ANALYSE PEP</text>
                
                <!-- Onde de Flow -->
                <path class="animate-flow" d="M30 110 Q 60 70 90 110 T 150 110 T 210 110" fill="none" stroke="url(#pepGrad)" stroke-width="3" stroke-linecap="round" />
                
                <text x="30" y="80" fill="#0f172a" font-size="20" font-weight="800" font-family="sans-serif">Votre Flow</text>
            </g>
        </svg>
    </div>
</body>
</html>
