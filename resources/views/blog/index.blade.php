<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8">Notre Blog</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($post->cover_image)
                            <img src="/storage/{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! $post->vignette_content !!}
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <span>{{ $post->category }}</span>
                                <span class="mx-2">&bull;</span>
                                <span>{{ $post->published_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
