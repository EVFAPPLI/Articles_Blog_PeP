@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pep-bg text-pep-dark font-sans selection:bg-blue-100">
    
    <!-- Hero Section -->
    <header class="pt-32 pb-20 px-6 lg:pt-40">
        <div class="max-w-7xl mx-auto text-center lg:text-left">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold uppercase tracking-widest bg-blue-50 text-blue-700 rounded-full border border-blue-100">
                        Inspiration & Efficience
                    </span>
                    <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-8">
                        Penser plus clair, <br />
                        <span class="italic text-gray-400 font-normal underline decoration-blue-200">agir plus vite.</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-lg mb-10 leading-relaxed mx-auto lg:mx-0">
                        Le portail de ressources pour maîtriser votre temps et votre attention dans un monde saturé d'informations.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="{{ route('blog.index') }}" class="bg-pep-dark text-white px-8 py-4 rounded-full font-bold hover:bg-pep-accent transition-all duration-300 transform hover-lift inline-flex items-center justify-center">
                            Explorer les articles
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl transform rotate-2">
                        <img 
                            src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80&w=1200" 
                            alt="Minimalist office"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="absolute -bottom-10 -left-10 bg-white p-8 rounded-2xl shadow-xl max-w-[300px] border border-gray-50 transform -rotate-2">
                        <div class="text-blue-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-lg mb-2">Méthodes PEP®</h3>
                        <p class="text-sm text-gray-500 mb-4">L'expertise internationale pour regagner votre temps et votre sérénité.</p>
                        <a href="https://pep.world/" target="_blank" class="text-sm font-bold flex items-center text-blue-600 group">
                            Découvrir <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Bento Grid Univers PEP -->
    <section class="py-20 bg-gray-50/50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-serif font-bold mb-12 text-center lg:text-left">Inspirations par Univers</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <!-- Esprit PEP -->
                <div class="md:col-span-2 lg:col-span-3 group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden relative min-h-[300px] flex flex-col justify-end">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <span class="text-emerald-600 font-bold text-xs uppercase tracking-widest mb-2 block flex items-center gap-2">
                            Mental & Humain <span class="px-2 py-0.5 bg-emerald-100 rounded-full text-[10px]">{{ $categoryCounts['Esprit PEP'] ?? 0 }} article{{ ($categoryCounts['Esprit PEP'] ?? 0) > 1 ? 's' : '' }}</span>
                        </span>
                        <h3 class="text-2xl font-serif font-bold mb-4">Esprit PEP</h3>
                        <p class="text-gray-500 text-sm mb-6">Moteur humain, charge mentale et psychologie de la performance.</p>
                        <a href="{{ route('blog.index', ['category' => 'Esprit PEP']) }}" class="text-pep-dark font-bold text-sm inline-flex items-center group/link">
                            Lire les articles <svg class="ml-2 w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Boîte à outils -->
                <div class="md:col-span-2 lg:col-span-3 group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 min-h-[300px] flex flex-col justify-end">
                    <div class="relative z-10">
                        <span class="text-blue-600 font-bold text-xs uppercase tracking-widest mb-2 block flex items-center gap-2">
                            Logiciels & IA <span class="px-2 py-0.5 bg-blue-100 rounded-full text-[10px]">{{ $categoryCounts['Boîte à outils'] ?? 0 }} article{{ ($categoryCounts['Boîte à outils'] ?? 0) > 1 ? 's' : '' }}</span>
                        </span>
                        <h3 class="text-2xl font-serif font-bold mb-4">Boîte à outils</h3>
                        <p class="text-gray-500 text-sm mb-6">Optimisez votre quotidien avec les meilleurs outils et l'intelligence artificielle.</p>
                        <a href="{{ route('blog.index', ['category' => 'Boîte à outils']) }}" class="text-pep-dark font-bold text-sm inline-flex items-center group/link">
                            Explorer <svg class="ml-2 w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Pilotage -->
                <div class="md:col-span-2 group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 min-h-[300px] flex flex-col justify-between">
                    <span class="text-amber-600 font-bold text-xs uppercase tracking-widest mb-2 block flex items-center gap-2">
                        Temps & Priorités <span class="px-2 py-0.5 bg-amber-100 rounded-full text-[10px]">{{ $categoryCounts['Pilotage'] ?? 0 }} article{{ ($categoryCounts['Pilotage'] ?? 0) > 1 ? 's' : '' }}</span>
                    </span>
                    <div>
                        <h3 class="text-2xl font-serif font-bold mb-4">Pilotage</h3>
                        <p class="text-gray-500 text-sm mb-6">Maîtrisez votre agenda et vos priorités stratégiques.</p>
                    </div>
                    <a href="{{ route('blog.index', ['category' => 'Pilotage']) }}" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Leadership -->
                <div class="md:col-span-2 group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 min-h-[300px] flex flex-col justify-between">
                    <span class="text-indigo-600 font-bold text-xs uppercase tracking-widest mb-2 block flex items-center gap-2">
                        Management <span class="px-2 py-0.5 bg-indigo-100 rounded-full text-[10px]">{{ $categoryCounts['Leadership'] ?? 0 }} article{{ ($categoryCounts['Leadership'] ?? 0) > 1 ? 's' : '' }}</span>
                    </span>
                    <div>
                        <h3 class="text-2xl font-serif font-bold mb-4">Leadership</h3>
                        <p class="text-gray-500 text-sm mb-6">Collaborer, déléguer et inspirer à l'ère du numérique.</p>
                    </div>
                    <a href="{{ route('blog.index', ['category' => 'Leadership']) }}" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Flow -->
                <div class="md:col-span-2 group bg-pep-dark text-white p-8 rounded-3xl border border-pep-dark shadow-sm hover:shadow-xl transition-all duration-500 min-h-[300px] flex flex-col justify-between">
                    <span class="text-purple-400 font-bold text-xs uppercase tracking-widest mb-2 block flex items-center gap-2">
                        Équilibre & Sérénité <span class="px-2 py-0.5 bg-purple-900/50 rounded-full text-[10px]">{{ $categoryCounts['Flow'] ?? 0 }} article{{ ($categoryCounts['Flow'] ?? 0) > 1 ? 's' : '' }}</span>
                    </span>
                    <div>
                        <h3 class="text-2xl font-serif font-bold mb-4">Flow</h3>
                        <p class="text-gray-400 text-sm mb-6">Atteindre l'état de concentration profonde et préserver son énergie.</p>
                    </div>
                    <a href="{{ route('blog.index', ['category' => 'Flow']) }}" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-purple-500 transition-all font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Articles Section -->
    @if(isset($latestPosts) && $latestPosts->count() > 0)
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-serif font-bold mb-4">À la une</h2>
                    <p class="text-gray-500">Les dernières réflexions pour votre efficacité professionnelle.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="hidden md:flex items-center font-bold text-sm uppercase tracking-widest text-gray-400 hover:text-pep-accent transition-colors">
                    Tous les articles <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                <article class="group bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all flex flex-col h-full hover-lift">
                    @if($post->cover_image)
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-6">
                        <img 
                            src="{{ Storage::url($post->cover_image) }}" 
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                    </div>
                    @endif
                    <span class="text-blue-600 font-bold text-[10px] uppercase tracking-widest mb-3 block">
                        {{ $post->category }}
                    </span>
                    <h3 class="text-xl font-serif font-bold mb-4 group-hover:text-blue-600 transition-colors flex-grow">
                        {{ $post->title }}
                    </h3>
                    <div class="pt-6 border-t border-gray-50 flex items-center justify-between text-xs text-gray-400 font-medium">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $post->created_at->format('d M Y') }}
                        </span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-pep-dark font-bold hover:text-pep-accent">Lire la suite</a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Promo Livre Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-gray-50 rounded-[3rem] p-10 lg:p-16 border border-gray-100 shadow-xl overflow-hidden relative flex flex-col lg:flex-row items-center gap-16">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-pep-accent/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="w-full lg:w-1/3 flex-shrink-0 relative z-10 flex justify-center">
                    <img src="https://pep.world/wp-content/uploads/2019/07/cover_ebookSiSimple07.05.2019-1.jpg" alt="Livre Si Simple ! par Bruno Savoyat" class="w-64 md:w-80 rounded-r-2xl rounded-l-md shadow-2xl transform -rotate-2 hover:rotate-0 transition-transform duration-500 border-l-8 border-slate-800">
                </div>

                <div class="w-full lg:w-2/3 relative z-10 text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-6">
                        <img src="https://pep.world/wp-content/uploads/2019/07/logo-sky-blue-on-couleur.png" alt="PEP World" class="h-8">
                        <span class="h-4 w-px bg-gray-300"></span>
                        <span class="text-pep-accent font-bold tracking-widest text-xs uppercase">Sélection Lecture</span>
                    </div>
                    
                    <h2 class="text-3xl lg:text-5xl font-serif font-black mb-6 text-pep-dark leading-tight">
                        15 moyens pour dynamiser votre vie et votre travail
                    </h2>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Un livre avec lequel vous allez optimiser votre efficacité personnelle, que ce soit au travail ou à la maison. 15 moyens et des principes simples pour des résultats extraordinaires. Plus d'un million de personnes ont déjà expérimenté la plupart de ces principes pour dynamiser leur vie professionnelle et privée et vivre plus heureux.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 text-sm text-gray-500 mb-10">
                        <div class="flex flex-col gap-1 text-center lg:text-left">
                            <span class="font-bold text-gray-900">Auteur : Bruno Savoyat</span>
                            <span>ISBN : <span class="font-mono">978-2-9566840-6-0</span></span>
                        </div>
                        <div class="hidden sm:block w-px h-10 bg-gray-200"></div>
                        <div class="flex flex-col gap-1 text-center lg:text-left">
                            <span>419 pages (17 cm x 2.15 cm x 24 cm)</span>
                            <span>Aussi en format ebook (Fr, En, Nl)</span>
                        </div>
                    </div>

                    <a href="https://pep.world/" target="_blank" class="inline-flex items-center justify-center bg-pep-accent text-white px-8 py-4 rounded-full font-bold hover:bg-blue-700 transition-all duration-300 transform hover-lift shadow-lg hover:shadow-blue-500/30">
                        COMMANDER LE LIVRE SUR PEP.WORLD
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-24 px-6 overflow-hidden relative bg-pep-bg">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-blue-50/50 -skew-x-12 translate-x-1/2 -z-10"></div>
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-8 text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7 8.914a.5.5 0 00.828 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <h2 class="text-4xl font-serif font-bold mb-6">Rejoignez le HUB Réflexion</h2>
            <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                Chaque semaine, recevez les meilleures stratégies d'efficacité et d'équilibre directement dans votre boîte mail.
            </p>
            <form class="flex flex-col sm:flex-row gap-4 p-2 bg-white rounded-2xl shadow-xl border border-gray-100 max-w-2xl mx-auto">
                <input 
                    type="email" 
                    placeholder="votre@email.com" 
                    class="flex-grow px-6 py-4 rounded-xl focus:outline-none"
                    required
                />
                <button type="submit" class="bg-pep-dark text-white px-8 py-4 rounded-xl font-bold hover:bg-pep-accent transition-all flex items-center justify-center">
                    S'abonner <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            <p class="mt-6 text-xs text-gray-400 italic">
                Zéro spam. Désinscription possible à tout moment.
            </p>
        </div>
    </section>

</div>

<footer class="bg-pep-dark text-white pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
            <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-8">
                    <a href="https://pep.world/" target="_blank" class="hover:opacity-80 transition-opacity">
                        <img src="https://pep.world/wp-content/uploads/2019/07/logo-sky-blue-on-couleur.png" alt="PEP World Logo" class="h-10">
                    </a>
                    <span class="text-2xl font-serif font-bold tracking-tight italic border-l border-gray-700 pl-3">PEP.uno</span>
                </div>
                <p class="text-gray-400 max-w-sm mb-8 leading-relaxed">
                    Plateforme dédiée à l'efficience personnelle et collective. Inspiré par les méthodes PEP® internationales.
                </p>
            </div>
            <div>
                <h4 class="font-bold uppercase tracking-widest text-xs mb-8 text-gray-500">Univers</h4>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li><a href="{{ route('blog.index', ['category' => 'Esprit PEP']) }}" class="hover:text-white transition-colors">Esprit PEP</a></li>
                    <li><a href="{{ route('blog.index', ['category' => 'Pilotage']) }}" class="hover:text-white transition-colors">Pilotage</a></li>
                    <li><a href="{{ route('blog.index', ['category' => 'Leadership']) }}" class="hover:text-white transition-colors">Leadership</a></li>
                    <li><a href="{{ route('blog.index', ['category' => 'Flow']) }}" class="hover:text-white transition-colors">Flow</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold uppercase tracking-widest text-xs mb-8 text-gray-500">Bruno Savoyat</h4>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li><a href="https://bruno-savoyat.com/" target="_blank" class="hover:text-white transition-colors">Le site Officiel</a></li>
                    <li><a href="https://pep.world/" target="_blank" class="hover:text-white transition-colors">PEP World</a></li>
                    <li><a href="https://linkedin.com/in/brunosavoyat" target="_blank" class="hover:text-white transition-colors">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-10 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 gap-4">
            <p>© {{ date('Y') }} PEP.uno. Tous droits réservés.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition-colors">Mentions Légales</a>
                <a href="#" class="hover:text-white transition-colors">Politique de Confidentialité</a>
            </div>
        </div>
    </div>
</footer>
@endsection
