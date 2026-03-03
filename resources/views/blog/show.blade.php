@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-inter selection:bg-blue-100">
    
    <!-- Floating Back Button -->
    <a href="{{ route('blog.index') }}" class="floating-back">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour au blog
    </a>

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- 1. Cover Image (Visibloo Style) -->
        @if($post->cover_image)
            <div class="mb-12 rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white transform rotate-1">
                <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}"
                    class="w-full h-auto object-cover max-h-[600px]">
            </div>
        @endif

        <!-- 2. Header Expert -->
        <header class="mb-14 text-center">
            @if($post->category)
                @php
                    $badgeClass = match($post->category) {
                        'Esprit PEP' => 'badge-esprit-pep',
                        'Boîte à outils' => 'badge-boite-a-outils',
                        'Pilotage' => 'badge-pilotage',
                        'Leadership' => 'badge-leadership',
                        'Flow' => 'badge-flow',
                        default => 'bg-gray-100 text-gray-700 border-gray-200'
                    };
                @endphp
                <span class="inline-block px-5 py-2 rounded-full uppercase tracking-[0.2em] text-[11px] font-black border {{ $badgeClass }} shadow-sm mb-8">
                    {{ $post->category }}
                </span>
            @endif

            <h1 class="text-4xl md:text-5xl font-black text-pep-dark leading-[1.1] mb-8 tracking-tight">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-400 font-medium">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $post->published_at ? $post->published_at->locale('fr')->translatedFormat('d F Y') : $post->created_at->locale('fr')->translatedFormat('d F Y') }}
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Par <span class="text-pep-dark font-bold">{{ $post->author ?? 'Visibloo' }}</span>
                </span>
            </div>
        </header>

        <!-- 3. HTML Content (Advanced Prose) -->
        <div class="prose prose-lg prose-slate max-w-none 
                    prose-h2:text-3xl prose-h2:font-black prose-h2:text-pep-dark prose-h2:mt-20 prose-h2:mb-10 prose-h2:tracking-tight
                    prose-p:text-slate-600 prose-p:leading-[2] prose-p:mb-12 prose-p:text-[1.15rem]
                    prose-strong:text-pep-dark prose-strong:font-extrabold
                    prose-em:text-pep-accent prose-em:italic prose-em:font-medium
                    prose-ul:list-disc prose-ul:pl-6 prose-ul:space-y-6 prose-ul:mb-12
                    prose-img:rounded-[2rem] prose-img:shadow-2xl prose-img:my-16">
            {!! preg_replace('/<h1(.*?)>(.*?)<\/h1>/is', '<h2$1>$2</h2>', $post->html_content) !!}
        </div>

        @if($post->keywords)
            <div class="mt-20 pt-10 border-t border-gray-100 flex flex-wrap justify-center gap-2">
                @foreach(is_array($post->keywords) ? $post->keywords : json_decode($post->keywords, true) as $keyword)
                    <span class="px-4 py-1.5 bg-gray-50 text-gray-500 rounded-full text-xs font-semibold hover:bg-pep-accent hover:text-white transition-colors">
                        #{{ $keyword }}
                    </span>
                @endforeach
            </div>
        @endif

    </article>

    <!-- Footer Minimal -->
    <div class="border-t border-gray-50 py-12 text-center bg-gray-50/50 mt-20">
        <p class="text-xs text-gray-400">PEP.uno © {{ date('Y') }} — Hub de Réflexion</p>
    </div>
</div>
@endsection
