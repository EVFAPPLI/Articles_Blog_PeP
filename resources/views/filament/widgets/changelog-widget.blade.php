<x-filament-widgets::widget>
    <x-filament::section>
        {{-- En-tête du Widget --}}
        <div class="flex items-center gap-x-3 mb-6">
            <div class="bg-primary-500/10 p-2.5 rounded-lg border border-primary-500/20">
                <x-heroicon-o-megaphone class="w-6 h-6 text-primary-600 dark:text-primary-400" />
            </div>
            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">Nouveautés & Mises à jour</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Retrouvez ici toutes les dernières fonctionnalités déployées.</p>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="space-y-6 mt-6">
            @foreach($releases as $release)
                <div class="relative pl-6 sm:pl-8 pb-4 before:absolute before:inset-0 before:left-2 before:-translate-x-px before:h-full before:w-0.5 before:bg-gray-200 dark:before:bg-white/10 last:before:h-0">
                    
                    <!-- Pastille chronologie -->
                    <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full border-2 border-white dark:border-gray-900 bg-primary-500 shadow-sm"></div>
                    
                    <!-- Carte Release -->
                    <div class="bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl p-5 hover:border-primary-500/30 transition-colors duration-300">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2 border-b border-gray-200 dark:border-white/10 pb-3">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                {{ $release['title'] }} 
                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300">
                                    v{{ $release['version'] }}
                                </span>
                            </h3>
                            <time class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1.5 min-w-max">
                                <x-heroicon-o-clock class="w-4 h-4" />
                                {{ $release['date'] }}
                            </time>
                        </div>
                        
                        <!-- Liste des changements -->
                        <ul class="space-y-3">
                            @foreach($release['changes'] as $change)
                                <li class="text-sm bg-white dark:bg-gray-900 border border-gray-100 dark:border-white/5 p-3 rounded-lg text-gray-600 dark:text-gray-300 flex flex-col sm:flex-row sm:items-start gap-3 shadow-sm hover:shadow transition-shadow">
                                    <x-filament::badge :color="$change['color']" size="sm" class="shrink-0 w-max shadow-sm">
                                        {{ $change['type'] }}
                                    </x-filament::badge>
                                    <span class="leading-relaxed pt-0.5">{{ $change['text'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
