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

    <!-- Promo Livre Section (Premium Layout Garanti) -->
    <section class="py-24 bg-gray-50/50 border-y border-gray-100" style="background-color: #f8fafc; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 6rem 0;">
        <div class="max-w-7xl mx-auto px-6" style="max-width: 80rem; margin: 0 auto; padding: 0 1.5rem;">
            
            <div class="bg-white" style="background-color: white; border-radius: 2.5rem; padding: 3rem; border: 1px solid #f1f5f9; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05); display: flex; flex-direction: column; gap: 3rem; position: relative; overflow: hidden; justify-content: space-between; align-items: center;" id="bookPromoContainer">
                
                <!-- Script simple pour gestion responsive de la grid inline -->
                <script>
                    function adjustBookPromoLayout() {
                        const container = document.getElementById('bookPromoContainer');
                        if (window.innerWidth >= 1024) {
                            container.style.flexDirection = 'row';
                            container.style.padding = '4rem';
                            container.style.gap = '4rem';
                        } else {
                            container.style.flexDirection = 'column';
                            container.style.padding = '2rem';
                            container.style.gap = '2rem';
                        }
                    }
                    window.addEventListener('resize', adjustBookPromoLayout);
                    window.addEventListener('DOMContentLoaded', adjustBookPromoLayout);
                </script>

                <!-- Background Decoration -->
                <div style="position: absolute; top: -5rem; right: -5rem; width: 24rem; height: 24rem; background-color: #eff6ff; border-radius: 50%; filter: blur(60px); opacity: 0.6; z-index: 0; pointer-events: none;"></div>
                <div style="position: absolute; bottom: -5rem; left: -5rem; width: 24rem; height: 24rem; background-color: #ecfdf5; border-radius: 50%; filter: blur(60px); opacity: 0.6; z-index: 0; pointer-events: none;"></div>

                <!-- Left: Content -->
                <div style="flex: 1; z-index: 10; width: 100%;">
                    
                    <div style="display: inline-flex; align-items: center; gap: 0.75rem; background-color: #eff6ff; color: #1d4ed8; padding: 0.5rem 1rem; border-radius: 9999px; margin-bottom: 2rem; border: 1px solid #dbeafe;">
                        <img src="https://pep.world/wp-content/uploads/2019/07/logo-sky-blue-on-couleur.png" alt="PEP World" style="height: 1.25rem;">
                        <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Sélection Lecture</span>
                    </div>

                    <h2 style="font-family: 'Instrument Serif', serif; font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; line-height: 1.1; color: #0f172a; margin-bottom: 1.5rem;">
                        15 moyens pour dynamiser <br/>
                        <span style="font-style: italic; font-weight: 400; color: #64748b;">votre vie et votre travail</span>
                    </h2>

                    <p style="font-size: 1.125rem; color: #475569; line-height: 1.7; margin-bottom: 2.5rem; max-width: 40rem;">
                        Un livre incontournable pour optimiser votre efficacité personnelle. Des principes simples pour des résultats extraordinaires. Déjà plébiscité par des milliers de lecteurs.
                    </p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 3rem; max-width: 35rem;">
                        <div style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 1.25rem; padding: 1.5rem;">
                            <span style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Auteur</span>
                            <span style="display: block; font-size: 1.25rem; font-weight: 900; color: #0f172a;">Bruno Savoyat</span>
                        </div>
                        <div style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 1.25rem; padding: 1.5rem;">
                            <span style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.25rem;">Détails</span>
                            <span style="display: block; font-size: 1.125rem; font-weight: 900; color: #0f172a;">419 pages (aussi en E-Book)</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                        <a href="https://pep.world/boutique/" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; background-color: #0f172a; color: white; padding: 1.25rem 2.5rem; border-radius: 9999px; font-weight: 800; font-size: 1rem; text-decoration: none; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.4); border: 2px solid transparent; transition: all 0.3s ease;" class="hover:bg-blue-600 hover:-translate-y-1" onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-2px)';" onmouseout="this.style.backgroundColor='#0f172a'; this.style.transform='translateY(0)';">
                            COMMANDER LE LIVRE
                            <svg style="margin-left: 0.75rem; width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <span style="font-family: monospace; font-size: 0.875rem; color: #94a3b8; font-weight: 600;">ISBN: 978-2-9566840-6-0</span>
                    </div>
                </div>

                <!-- Right: Visual -->
                <div style="flex: 1; display: flex; justify-content: center; position: relative; width: 100%;">
                    <!-- Decorative Glow behind book -->
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; height: 80%; background-color: rgba(59, 130, 246, 0.15); filter: blur(40px); border-radius: 50%; z-index: 0;"></div>
                    
                    <div style="position: relative; z-index: 10; display: flex; justify-content: center;">
                        <img 
                            src="https://pep.world/wp-content/uploads/2019/07/cover_ebookSiSimple07.05.2019-1.jpg" 
                            alt="Couverture du Livre Si Simple !" 
                            style="width: 100%; max-width: 320px; height: auto; border-radius: 0 1.5rem 1.5rem 0.5rem; box-shadow: 20px 20px 60px rgba(0,0,0,0.3); border-left: 14px solid #182a45; transform: perspective(1000px) rotateY(-12deg) rotateZ(-3deg); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);"
                            onmouseover="this.style.transform='perspective(1000px) rotateY(0) rotateZ(0) scale(1.05)'"
                            onmouseout="this.style.transform='perspective(1000px) rotateY(-12deg) rotateZ(-3deg) scale(1)'"
                        >
                        <!-- Floating Badge -->
                        <div style="position: absolute; bottom: -20px; left: -20px; background-color: white; padding: 1.25rem 1.5rem; border-radius: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 1rem; transform: rotate(-5deg); transition: transform 0.4s ease; z-index: 20;" onmouseover="this.style.transform='rotate(0) scale(1.05)'" onmouseout="this.style.transform='rotate(-5deg) scale(1)'">
                            <div style="width: 3rem; height: 3rem; border-radius: 50%; background-color: #eff6ff; color: #3b82f6; display: flex; justify-content: center; align-items: center; flex-shrink: 0;">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <div style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800; color: #94a3b8; margin-bottom: 0.125rem;">Méthodologie</div>
                                <div style="font-size: 1rem; font-weight: 900; color: #0f172a;">Testé & Approuvé</div>
                            </div>
                        </div>
                    </div>
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
