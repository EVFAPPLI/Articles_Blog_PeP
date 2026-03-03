<x-app-layout>
    <article class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($post->cover_image)
                <img src="/storage/{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-xl shadow-lg mb-8">
            @endif

            <header class="mb-8">
                <div class="flex items-center gap-2 text-indigo-600 font-medium mb-4">
                    <span class="px-3 py-1 bg-indigo-100 rounded-full text-xs uppercase tracking-wider">{{ $post->category }}</span>
                    <span class="text-gray-400">&bull;</span>
                    <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d/m/Y') }}</time>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    {{ $post->title }}
                </h1>
                <p class="text-gray-500">Par {{ $post->author }}</p>
            </header>

            <div class="prose prose-indigo lg:prose-xl max-w-none">
                {!! $post->html_content !!}
            </div>

            @if($post->keywords)
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->keywords as $keyword)
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm">#{{ $keyword }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>
</x-app-layout>
