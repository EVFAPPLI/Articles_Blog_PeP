@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pep-bg pt-32 pb-20 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Blog Header -->
        <header class="mb-16 text-center lg:text-left">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold uppercase tracking-widest bg-blue-50 text-blue-700 rounded-full border border-blue-100">
                Hub de Réflexion
            </span>
            <h1 class="text-4xl md:text-6xl font-serif font-bold mb-6">
                @if(request('category'))
                    Articles : <span class="italic text-gray-400">{{ request('category') }}</span>
                @else
                    Toutes nos <span class="italic text-gray-400">inspirations</span>
                @endif
            </h1>
            <p class="text-lg text-gray-500 max-w-2xl leading-relaxed">
                Découvrez nos dernières stratégies sur l'efficacité, le leadership et l'équilibre travail-vie personnelle.
            </p>
        </header>

        <!-- Category Filters -->
        <div class="flex flex-wrap gap-3 mb-12">
            @php
                $categories = [
                    'Tous' => null,
                    'Esprit PEP' => 'emerald',
                    'Boîte à outils' => 'blue',
                    'Pilotage' => 'amber',
                    'Leadership' => 'indigo',
                    'Flow' => 'purple'
                ];
            @endphp

            @foreach($categories as $name => $color)
                <a href="{{ $name === 'Tous' ? route('blog.index') : route('blog.index', ['category' => $name]) }}" 
                   class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 border 
                   {{ (request('category') == $name || (request('category') == null && $name == 'Tous')) 
                        ? 'bg-pep-dark text-white border-pep-dark' 
                        : 'bg-white text-gray-500 border-gray-100 hover:border-pep-accent' }}">
                    {{ $name }}
                </a>
            @endforeach
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="group bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all flex flex-col h-full hover-lift">
                    @if($post->cover_image)
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-6">
                        <img 
                            src="{{ Storage::url($post->cover_image) }}" 
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                    </div>
                    @else
                    <div class="aspect-[16/10] rounded-2xl bg-gray-50 mb-6 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    @endif

                    <div class="flex-grow">
                        <span class="text-{{ $post->category == 'Esprit PEP' ? 'emerald' : ($post->category == 'Boîte à outils' ? 'blue' : ($post->category == 'Pilotage' ? 'amber' : ($post->category == 'Leadership' ? 'indigo' : 'purple'))) }}-600 font-bold text-[10px] uppercase tracking-widest mb-3 block">
                            {{ $post->category }}
                        </span>
                        <h3 class="text-2xl font-serif font-bold mb-4 group-hover:text-blue-600 transition-colors leading-tight">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <div class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">
                            {!! strip_tags($post->vignette_content, '<strong><em><b><i>') !!}
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-50 flex items-center justify-between text-xs text-gray-400 font-medium">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-pep-dark font-bold hover:text-pep-accent transition-colors">Explorer</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-gray-200">
                    <p class="text-gray-500 italic">Aucun article trouvé dans cette catégorie.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
