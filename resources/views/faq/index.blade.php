@extends('layouts.app')

@section('content')
<main class="min-h-screen pt-32 pb-24 relative overflow-hidden bg-pep-bg" style="background-color: #f8fafc;">
    
    <!-- Background Decorators -->
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-100 rounded-full blur-[120px] opacity-50 -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-50 rounded-full blur-[100px] opacity-60 translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        
        <!-- HEADER -->
        <div class="text-center mb-16">
            <h1 class="font-serif font-black text-5xl md:text-7xl text-pep-dark mb-6 tracking-tight leading-none" style="font-family: 'Instrument Serif', serif;">
                Foire Aux <span class="italic text-pep-accent">Questions</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-500 font-medium max-w-2xl mx-auto">
                L'expertise de la méthodologie PEP® répond à vos interrogations. Découvrez comment optimiser votre espace de travail et gagner en efficacité.
            </p>
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
    </div>
</main>

<!-- AlpineJS -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
