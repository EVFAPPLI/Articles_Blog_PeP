@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pep-bg pt-32 pb-20 selection:bg-blue-100 relative overflow-hidden">
    <!-- Orbes lumineux décoratifs (Liquid Glass) -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-emerald-100/50 rounded-[100%] blur-[120px] -z-10 opacity-70"></div>
    <div class="absolute top-40 -left-64 w-[600px] h-[600px] bg-blue-100/40 rounded-[100%] blur-[100px] -z-10 opacity-60"></div>
    <div class="absolute top-20 -right-40 w-[500px] h-[500px] bg-purple-100/30 rounded-[100%] blur-[100px] -z-10 opacity-50"></div>

    <div class="max-w-7xl mx-auto px-6 mb-16 relative z-10">
        <div class="text-center">
            <div class="inline-flex items-center justify-center space-x-2 bg-white/60 backdrop-blur-md px-4 py-1.5 rounded-full border border-white shadow-sm mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-700">Test d'Expertise IA</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-serif font-black text-pep-dark mb-6 tracking-tight leading-tight">
                Le Défi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-blue-600">PEP</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-500 max-w-2xl mx-auto font-light leading-relaxed">
                Mettez à l'épreuve vos connaissances et vos réflexes en matière d'efficacité professionnelle.
            </p>
        </div>
    </div>

    @if(isset($activeQuiz) && $activeQuiz->questions->count() > 0)
        <!-- Inclusion de notre composant propre -->
        @include('components.home.quiz-section')
    @else
        <div class="max-w-3xl mx-auto px-6 text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            <h2 class="text-2xl font-serif font-bold text-pep-dark mb-2">Aucun défi pour le moment</h2>
            <p class="text-gray-500 mb-8">Revenez plus tard pour découvrir notre prochain quiz interactif.</p>
            <a href="{{ route('home') }}" class="bg-pep-dark text-white px-8 py-4 rounded-full font-bold hover:bg-pep-accent transition-colors display-inline-block">Retour à l'accueil</a>
        </div>
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
</div>
@endsection
