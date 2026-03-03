@extends('layouts.app')

@section('content')
<main class="min-h-screen pt-32 pb-24 relative overflow-hidden bg-pep-bg" style="background-color: #f8fafc;">
    
    <!-- Background Decorators -->
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-100 rounded-full blur-[120px] opacity-50 -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-50 rounded-full blur-[100px] opacity-60 translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row items-center gap-12 mb-16">
            <div class="flex-1 text-center md:text-left">
                <h1 class="font-serif font-black text-5xl md:text-7xl text-pep-dark mb-6 tracking-tight leading-none" style="font-family: 'Instrument Serif', serif;">
                    Foire Aux <br class="hidden xl:block"/><span class="italic text-pep-accent">Questions</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-500 font-medium max-w-lg mx-auto md:mx-0">
                    L'expertise de la méthodologie PEP® répond à vos interrogations. Découvrez comment optimiser votre espace de travail et gagner en efficacité.
                </p>
            </div>
            <div class="flex-1 w-full flex justify-center md:justify-end relative">
                <!-- Decorative element behind image -->
                <div class="absolute inset-0 bg-pep-accent/10 rounded-3xl transform rotate-3 scale-105 pointer-events-none"></div>
                <img 
                    src="https://bruno.appliscreaweb.fr/public/faq_pep_uno.webp" 
                    alt="PEP FAQ Illustration" 
                    class="relative w-full max-w-sm rounded-3xl shadow-2xl transform -rotate-2 hover:rotate-0 transition-transform duration-500"
                >
            </div>
        </div>

        <!-- FAQ ACCORDION LIST -->
        <div class="space-y-4">
            @forelse($faqs as $faq)
                <div 
                    x-data="{ open: false }" 
                    class="bg-white/70 backdrop-blur-xl border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl overflow-hidden transition-all duration-300"
                    :class="{'ring-2 ring-pep-accent/20 shadow-[0_15px_40px_rgb(0,0,0,0.08)]': open}"
                >
                    <button 
                        @click="open = !open" 
                        class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none"
                    >
                        <h3 class="font-bold text-lg md:text-xl text-pep-dark pr-8" style="font-family: 'Instrument Sans', sans-serif;">
                            {{ $faq->question }}
                        </h3>
                        <div 
                            class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center transition-transform duration-300"
                            :class="{'rotate-180 bg-pep-accent text-white': open}"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-collapse 
                        class="px-6 md:px-8 pb-6 md:pb-8 text-slate-600 leading-relaxed text-base md:text-lg prose prose-blue max-w-none"
                    >
                        <div class="pt-4 border-t border-slate-100 overflow-hidden">
                            {!! $faq->answer !!}
                            
                            @if($faq->target_keywords)
                            <div class="mt-6 flex flex-wrap gap-2">
                                @foreach(explode(',', $faq->target_keywords) as $keyword)
                                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider rounded-lg">
                                        {{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white/50 backdrop-blur-md rounded-3xl border border-white">
                    <p class="text-slate-400 font-medium">Aucune question n'est disponible pour le moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Animation SVG PEP -->
        <div class="mt-24 mb-16 flex justify-center w-full">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
                
                .pep-svg-content-wrapper {
                    width: 90%;
                    max-width: 900px;
                    filter: drop-shadow(0 20px 40px rgba(15, 23, 42, 0.1));
                    font-family: 'Plus Jakarta Sans', sans-serif;
                }

                /* Interactions des personnages */
                .pep-anim-character {
                    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
                    cursor: pointer;
                }

                .pep-anim-character:hover {
                    transform: translateY(-8px);
                }

                /* Bulles de pensée (Apparaissent au survol) */
                .pep-anim-thought-bubble {
                    opacity: 0;
                    transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    transform: scale(0.5);
                    transform-origin: center bottom;
                }

                .pep-anim-character:hover .pep-anim-thought-bubble {
                    opacity: 1;
                    transform: scale(1);
                }

                /* Animation du bras de l'expert */
                .pep-anim-expert-arm {
                    transform-origin: 165px 180px;
                    animation: pepWave 4s ease-in-out infinite;
                }

                @keyframes pepWave {
                    0%, 100% { transform: rotate(0deg); }
                    50% { transform: rotate(-8deg); }
                }

                /* Icônes qui flottent */
                .pep-anim-floating-icon {
                    animation: pepFloat 3s ease-in-out infinite;
                }

                @keyframes pepFloat {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-15px); }
                }

                /* Effet de pulsation (Focus) */
                .pep-anim-pulse {
                    animation: pepPulseRing 2s infinite;
                    transform-origin: center;
                }

                @keyframes pepPulseRing {
                    0% { transform: scale(0.8); opacity: 0.8; }
                    100% { transform: scale(1.5); opacity: 0; }
                }

                /* Apparition progressive des éléments - Sécurisé */
                .pep-anim-fade-in {
                    animation: pepFadeIn 1.2s ease-out forwards;
                }

                @keyframes pepFadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            </style>

            <div class="pep-svg-content-wrapper">
                <svg viewBox="0 0 800 450" xmlns="http://www.w3.org/2000/svg" class="pep-anim-fade-in max-w-full h-auto" style="display: block;">
                    <!-- Arrière-plan (Mur et Sol) -->
                    <rect x="0" y="0" width="800" height="450" fill="#f1f5f9" rx="20"/>
                    <rect x="50" y="380" width="700" height="8" rx="4" fill="#e2e8f0"/>
                    
                    <!-- Tableau de formation PEP -->
                    <rect x="150" y="60" width="220" height="160" rx="12" fill="white" stroke="#cbd5e1" stroke-width="3"/>
                    <text x="180" y="110" font-weight="800" font-size="28" fill="#0ea5e9">PEP</text>
                    <text x="180" y="145" font-size="14" font-weight="600" fill="#64748b">Penser plus CLAIR</text>
                    <text x="180" y="170" font-size="14" font-weight="600" fill="#10b981">Agir plus VITE</text>
                    <line x1="180" y1="190" x2="280" y2="190" stroke="#f1f5f9" stroke-width="6" stroke-linecap="round"/>
                    <line x1="180" y1="205" x2="240" y2="205" stroke="#f1f5f9" stroke-width="6" stroke-linecap="round"/>

                    <!-- L'Expert Formateur -->
                    <g class="pep-anim-expert">
                        <circle cx="165" cy="140" r="24" fill="#334155"/> <!-- Tête -->
                        <path d="M140 170 Q165 160 190 170 L200 280 L130 280 Z" fill="#475569"/> <!-- Corps -->
                        <rect x="150" y="280" width="12" height="70" fill="#334155" rx="4"/> <!-- Jambe G -->
                        <rect x="175" y="280" width="12" height="70" fill="#334155" rx="4"/> <!-- Jambe D -->
                        <path class="pep-anim-expert-arm" d="M185 185 L240 130" stroke="#475569" stroke-width="14" stroke-linecap="round"/> <!-- Bras -->
                    </g>

                    <!-- Table des participants -->
                    <rect x="420" y="300" width="320" height="15" rx="8" fill="#cbd5e1"/>
                    <rect x="440" y="315" width="12" height="65" fill="#94a3b8" rx="2"/>
                    <rect x="690" y="315" width="12" height="65" fill="#94a3b8" rx="2"/>

                    <!-- Participant 1 : Sérénité -->
                    <g class="pep-anim-character" id="p1">
                        <circle cx="480" cy="245" r="22" fill="#94a3b8"/> <!-- Tête -->
                        <path d="M440 275 Q480 265 520 275 L510 300 L450 300 Z" fill="#1e293b"/> <!-- Corps -->
                        <g class="pep-anim-thought-bubble">
                            <circle cx="480" cy="170" r="35" fill="white" stroke="#10b981" stroke-width="2"/>
                            <path d="M470 175 L475 180 L490 165" stroke="#10b981" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <text x="445" y="220" font-size="11" fill="#10b981" font-weight="bold">SÉRÉNITÉ</text>
                        </g>
                    </g>

                    <!-- Participant 2 : Focus -->
                    <g class="pep-anim-character" id="p2">
                        <circle cx="580" cy="235" r="22" fill="#64748b"/>
                        <path d="M540 265 Q580 255 620 265 L615 300 L545 300 Z" fill="#334155"/>
                        <g class="pep-anim-thought-bubble">
                            <circle cx="580" cy="160" r="35" fill="white" stroke="#0ea5e9" stroke-width="2"/>
                            <circle cx="580" cy="160" r="10" fill="none" stroke="#0ea5e9" stroke-width="2" class="pep-anim-pulse"/>
                            <text x="555" y="210" font-size="11" fill="#0ea5e9" font-weight="bold">FOCUS</text>
                        </g>
                    </g>

                    <!-- Participant 3 : Maîtrise du Temps -->
                    <g class="pep-anim-character" id="p3">
                        <circle cx="680" cy="245" r="22" fill="#475569"/>
                        <path d="M640 275 Q680 265 720 275 L710 300 L650 300 Z" fill="#1e293b"/>
                        <g class="pep-anim-thought-bubble">
                            <circle cx="680" cy="170" r="35" fill="white" stroke="#f59e0b" stroke-width="2"/>
                            <circle cx="680" cy="170" r="15" fill="none" stroke="#f59e0b" stroke-width="2"/>
                            <path d="M680 160 L680 170 L690 170" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                            <text x="655" y="220" font-size="11" fill="#f59e0b" font-weight="bold">TEMPS</text>
                        </g>
                    </g>

                    <!-- Icônes d'ambiance flottantes -->
                    <g class="pep-anim-floating-icon" style="animation-delay: 0s;">
                        <text x="620" y="80" font-size="24">💡</text>
                    </g>
                    <g class="pep-anim-floating-icon" style="animation-delay: 1.5s;">
                        <text x="80" y="120" font-size="24">🎯</text>
                    </g>
                    <g class="pep-anim-floating-icon" style="animation-delay: 0.8s;">
                        <text x="700" y="120" font-size="24">🚀</text>
                    </g>
                </svg>
            </div>
        </div>

    </div>
</main>

<!-- AlpineJS -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
