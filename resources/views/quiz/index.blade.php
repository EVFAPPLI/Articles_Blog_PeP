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
</div>
@endsection
