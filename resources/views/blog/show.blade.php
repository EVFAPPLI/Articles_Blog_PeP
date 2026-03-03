@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pep-bg pt-32 pb-20 px-6">
    <article class="max-w-4xl mx-auto">
        <!-- Article Header -->
        <header class="mb-12 text-center">
            <div class="flex items-center justify-center gap-3 mb-8">
                <a href="{{ route('blog.index', ['category' => $post->category]) }}" 
                   class="px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest 
                   {{ $post->category == 'Esprit PEP' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                      ($post->category == 'Boîte à outils' ? 'bg-blue-50 text-blue-600 border-blue-100' : 
                      ($post->category == 'Pilotage' ? 'bg-amber-50 text-amber-600 border-amber-100' : 
                      ($post->category == 'Leadership' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-purple-50 text-purple-600 border-purple-100'))) }} border">
                    {{ $post->category }}
                </a>
                <span class="text-gray-300">|</span>
                <time class="text-xs font-bold uppercase tracking-widest text-gray-400">
                    {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
                </time>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-serif font-bold leading-tight mb-8">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-center gap-4 text-sm text-gray-500 italic">
                <span>Par {{ $post->author ?? 'L\'Équipe PEP' }}</span>
            </div>
        </header>

        <!-- Cover Image -->
        @if($post->cover_image)
        <div class="mb-16 rounded-3xl overflow-hidden shadow-2xl transform -rotate-1">
            <img 
                src="{{ Storage::url($post->cover_image) }}" 
                alt="{{ $post->title }}"
                class="w-full h-full object-cover max-h-[500px]"
            />
        </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-lg prose-pep max-w-none 
                    prose-headings:font-serif prose-headings:font-bold prose-headings:text-pep-dark
                    prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline
                    prose-blockquote:border-l-4 prose-blockquote:border-blue-100 prose-blockquote:bg-blue-50/30 prose-blockquote:p-6 prose-blockquote:rounded-r-2xl prose-blockquote:italic
                    prose-img:rounded-3xl prose-img:shadow-lg
                    text-gray-700 leading-relaxed">
            {!! $post->html_content !!}
        </div>

        <!-- Article Footer (Keywords) -->
        @if($post->keywords && count($post->keywords) > 0)
        <footer class="mt-20 pt-10 border-t border-gray-100 text-center">
            <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">Mots-clés</h4>
            <div class="flex flex-wrap justify-center gap-2">
                @foreach($post->keywords as $keyword)
                    <span class="px-4 py-1.5 bg-white border border-gray-100 text-gray-500 rounded-full text-xs font-medium hover:border-pep-accent transition-colors cursor-default">
                        #{{ trim($keyword) }}
                    </span>
                @endforeach
            </div>
        </footer>
        @endif

        <!-- Back Link -->
        <div class="mt-20 text-center">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center font-bold text-sm uppercase tracking-widest text-pep-dark hover:text-pep-accent transition-colors group">
                <svg class="mr-2 w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour aux articles
            </a>
        </div>
    </article>
</div>

<!-- Newsletter Mini (Optional) -->
<section class="mt-20 py-20 bg-gray-50/50 border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h3 class="text-2xl font-serif font-bold mb-4">Cet article vous a plu ?</h3>
        <p class="text-gray-500 mb-8">Inscrivez-vous à notre newsletter pour ne rien manquer de nos futures publications.</p>
        <form class="flex flex-col sm:flex-row gap-4 p-1.5 bg-white rounded-2xl shadow-sm border border-gray-100 max-w-xl mx-auto">
            <input type="email" placeholder="votre@email.com" class="flex-grow px-6 py-3 rounded-xl focus:outline-none text-sm" required />
            <button type="submit" class="bg-pep-dark text-white px-6 py-3 rounded-xl font-bold hover:bg-pep-accent transition-all text-sm">S'abonner</button>
        </form>
    </div>
</section>

<style>
    /* Custom prose styles for better editorial rendering */
    .prose-pep h2 {
        @apply text-3xl mt-12 mb-6;
    }
    .prose-pep h3 {
        @apply text-2xl mt-8 mb-4;
    }
    .prose-pep p {
        @apply mb-6;
    }
</style>
@endsection
