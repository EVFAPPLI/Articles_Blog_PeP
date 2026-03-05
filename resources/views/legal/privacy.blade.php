@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pep-bg pt-40 pb-20 px-6">
    <article class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-16 text-center">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold uppercase tracking-widest bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                Protection des données
            </span>
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">Politique de confidentialité</h1>
            <p class="text-gray-400 italic font-medium">Dernière mise à jour le 4 mars 2026</p>
        </header>

        <!-- Intro -->
        <div class="bg-white p-8 md:p-12 rounded-[3rem] border border-gray-100 shadow-sm mb-16 leading-relaxed text-gray-600">
            <p class="mb-6">
                La présente Politique de confidentialité décrit la manière dont <span class="font-bold text-pep-dark">Bruno Savoyat</span> collecte, utilise et protège les informations que vous nous transmettez lorsque vous utilisez le site internet accessible à l’adresse <a href="https://bruno-savoyat.com/" class="text-blue-600 hover:underline text-break">https://bruno-savoyat.com/</a>.
            </p>
            <p>
                Nous nous engageons à ce que les données à caractère personnel vous concernant soient protégées et utilisées en conformité avec le <span class="font-bold text-pep-dark text-break">Règlement (UE) 2016/679 (RGPD)</span>.
            </p>
        </div>

        <!-- Content -->
        <div class="space-y-16 text-gray-700 leading-relaxed font-sans">
            
            <!-- Responsable -->
            <section class="group">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-emerald-600 transition-transform group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-serif font-bold">Responsable du traitement</h2>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="font-bold text-pep-dark text-lg mb-4">Bruno Savoyat</p>
                    <div class="text-sm text-gray-500 space-y-2">
                        <p><span class="font-bold text-gray-400">Adresse :</span> PEPworldwide, 66 avenue des Champs-Elysées, F – 75008 Paris</p>
                        <p><span class="font-bold text-gray-400">Email :</span> <a href="mailto:contact@pep.uno" class="text-blue-600">contact@pep.uno</a></p>
                        <p><span class="font-bold text-gray-400">Tél. :</span> +33 9 77 21 55 77</p>
                    </div>
                </div>
            </section>

            <!-- Collecte & Finalités -->
            <div class="grid md:grid-cols-2 gap-8">
                <section class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h2 class="text-xl font-serif font-bold mb-6 text-emerald-700">Données collectées</h2>
                    <ul class="space-y-6 text-sm text-gray-500">
                        <li class="flex gap-4">
                            <span class="text-emerald-500 font-bold">01.</span>
                            <p><span class="font-bold text-pep-dark block mb-1">Directement :</span> Via notre formulaire de contact (nom, email, message).</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-emerald-500 font-bold">02.</span>
                            <p><span class="font-bold text-pep-dark block mb-1">Automatiquement :</span> Cookies pour le fonctionnement et statistiques anonymes.</p>
                        </li>
                    </ul>
                </section>

                <section class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h2 class="text-xl font-serif font-bold mb-6 text-emerald-700">Finalités</h2>
                    <ul class="space-y-6 text-sm text-gray-500">
                        <li class="flex gap-4">
                            <span class="text-emerald-500 font-bold">✔️</span>
                            <p>Répondre à vos demandes de contact.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-emerald-500 font-bold">✔️</span>
                            <p>Gérer la relation commerciale.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-emerald-500 font-bold">✔️</span>
                            <p>Améliorer l'ergonomie de notre site.</p>
                        </li>
                    </ul>
                </section>
            </div>

            <!-- Conservation -->
            <section class="bg-gray-50 p-10 rounded-[3rem] border border-gray-100 text-center">
                <h2 class="text-2xl font-serif font-bold mb-4">Durée de conservation</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Les données sont conservées pendant la durée nécessaire au traitement de votre demande, puis archivées pour une durée maximale de <span class="font-bold text-pep-dark">3 ans</span>.
                </p>
            </section>

            <!-- Vos Droits -->
            <section>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-serif font-bold">Vos droits sur vos données</h2>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach([
                        ['Accès', 'Recevoir une copie de vos données.'],
                        ['Rectification', 'Corriger toute information inexacte.'],
                        ['Effacement', 'Droit à l’oubli (suppression).'],
                        ['Opposition', 'S\'opposer au traitement.'],
                        ['Limitation', 'Demander à limiter l\'usage.'],
                        ['Portabilité', 'Recevoir vos données structurées.']
                    ] as $droit)
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-pep-dark mb-2">{{ $droit[0] }}</h3>
                        <p class="text-xs text-gray-500">{{ $droit[1] }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mt-8 text-center p-6 bg-blue-50 rounded-2xl border border-blue-100 italic text-sm text-blue-800">
                    Pour exercer l’un de ces droits, contactez-nous par email à <a href="mailto:contact@pep.uno" class="font-bold underline">contact@pep.uno</a>
                </div>
            </section>

            <!-- Cookies -->
            <section class="prose prose-pep max-w-none bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 -mr-16 -mt-16 rounded-full opacity-50"></div>
                <h3 class="text-2xl font-serif font-bold mb-6 text-pep-dark">Gestion des cookies</h3>
                <div class="text-gray-500 text-sm space-y-4 relative z-10">
                    <p>Notre site utilise principalement des cookies fonctionnels (essentiels) et des cookies de mesure d'audience anonymes.</p>
                    <p>Vous pouvez à tout moment configurer votre navigateur pour gérer vos préférences. Pour plus d’informations : <a href="https://www.cnil.fr/fr/cookies-les-outils-pour-les-maitriser" target="_blank" class="text-emerald-600 font-bold hover:underline">Consulter la CNIL</a></p>
                </div>
            </section>

            <!-- Modification -->
            <footer class="text-center pt-10 border-t border-gray-100">
                <p class="text-xs text-gray-400 italic">
                    Nous nous réservons le droit de modifier la présente Politique de confidentialité à tout moment. Toute nouvelle version sera publiée ici.
                </p>
            </footer>

        </div>
    </article>
</div>
@endsection
