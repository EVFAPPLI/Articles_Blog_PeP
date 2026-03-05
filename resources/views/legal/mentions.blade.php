@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pep-bg pt-72 pb-20 px-6">
    <article class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-16 text-center">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold uppercase tracking-widest bg-blue-50 text-blue-700 rounded-full border border-blue-100">
                Informations Légales
            </span>
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">Mentions légales</h1>
            <p class="text-gray-400 italic font-medium">Dernière mise à jour le 4 mars 2026</p>
        </header>

        <!-- Content -->
        <div class="space-y-16 text-gray-700 leading-relaxed font-sans">
            
            <!-- Editeur -->
            <section class="group">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-blue-600 transition-transform group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h2 class="text-2xl font-serif font-bold">Editeur du site</h2>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <p class="font-bold text-pep-dark text-lg mb-4">PEPworldwide</p>
                    <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-500">
                        <div class="space-y-2">
                            <p class="flex items-start gap-2">
                                <span class="font-bold text-gray-400">Adresse :</span>
                                <span>66 avenue des Champs-Elysées, CS40152, 75008 Paris (France)</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="font-bold text-gray-400">Email :</span>
                                <a href="mailto:contact@PEP.uno" class="text-blue-600 hover:underline">contact@PEP.uno</a>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="font-bold text-gray-400">Tél. :</span>
                                <span>+33 9 77 21 55 77</span>
                            </p>
                        </div>
                        <div class="space-y-2">
                            <p>SARL immatriculée au RCS de PARIS B 400 018 420 le 13 mars 1995</p>
                            <p><span class="font-bold text-gray-400">Capital :</span> 31 000 €</p>
                            <p><span class="font-bold text-gray-400">TVA intracommunautaire :</span> FR81400018420</p>
                            <p><span class="font-bold text-gray-400">Numéro D-U-N-S :</span> 779144807</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Responsable & Hébergeur -->
            <div class="grid md:grid-cols-2 gap-8">
                <section class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm h-full">
                    <h2 class="text-xl font-serif font-bold mb-4">Responsable de la publication</h2>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        <span class="font-bold text-pep-dark">Bruno Savoyat</span>, joignable aux mêmes coordonnées que l’éditeur.
                    </p>
                </section>

                <section class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm h-full">
                    <h2 class="text-xl font-serif font-bold mb-4">Hébergeur</h2>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Le site <span class="text-blue-600 font-medium">bruno-savoyat.com</span> est hébergé par la société <span class="font-bold text-pep-dark">IONOS SARL</span><br>
                        (7, place de la Gare, BP 70109, 57200 Sarreguemines Cedex, SIREN 431 303 775 RCS Sarreguemines, tél. 0970 808 911, info@IONOS.fr)
                    </p>
                </section>
            </div>

            <!-- Protections -->
            <section class="bg-blue-50/50 p-10 rounded-[3rem] border border-blue-100 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-5">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-14h2v2h-2zm0 4h2v6h-2z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-serif font-bold mb-6 text-blue-900 border-b border-blue-200 pb-4">Protection de marque & Propriété</h2>
                    <div class="space-y-6 text-blue-900/80">
                        <p><span class="font-bold">PEP</span> est une marque protégée dans l’Union Européenne, en Suisse et dans de nombreux pays.</p>
                        <p>Sous réserve des droits de ses partenaires, le contenu du site est la propriété exclusive de l’Éditeur et est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.</p>
                        <p class="text-sm italic">Les éléments du site ne peuvent faire l’objet d’aucune utilisation sans autorisation expresse, sous peine de poursuites.</p>
                    </div>
                </div>
            </section>

            <!-- Liens Hypertextes & Informatique -->
            <div class="space-y-8">
                <div class="prose prose-pep max-w-none">
                    <h3 class="text-xl font-serif font-bold mb-4 text-pep-dark">Liens hypertextes</h3>
                    <p class="text-gray-500 text-sm">
                        L’Éditeur ne pourra en aucun cas être tenu pour responsable des informations diffusées sur les sites vers lesquels renvoient des liens hypertextes présents sur son site ainsi que de tous préjudices de quelque nature que ce soit résultant notamment de l’accès à ceux-ci.
                    </p>
                </div>

                <div class="prose prose-pep max-w-none bg-gray-50 p-8 rounded-3xl border border-gray-100">
                    <h3 class="text-xl font-serif font-bold mb-4 text-pep-dark">Loi Informatique et Libertés</h3>
                    <div class="text-gray-500 text-sm space-y-4">
                        <p>Conformément à la loi n° 78-17, vous disposez d’un droit d’accès et de rectification aux données vous concernant. Vous pouvez exercer ce droit en nous écrivant.</p>
                        <p>Les informations recueillies via le formulaire de contact sont conformes à la Loi Informatique et Libertés et servent exclusivement au traitement de vos demandes.</p>
                        <div class="pt-4 flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-100 inline-flex">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                            <p class="font-medium text-pep-dark">Gestion des cookies : 
                                <a href="https://www.cnil.fr/fr/cookies-les-outils-pour-les-maitriser" target="_blank" class="text-blue-600 hover:underline">En savoir plus sur la CNIL</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </article>
</div>
@endsection
