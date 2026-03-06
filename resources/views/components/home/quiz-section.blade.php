<!-- Quiz Interactif PEP (IA Powered) -->
@if(isset($activeQuiz) && $activeQuiz->questions->count() > 0)
<section class="py-24 relative overflow-hidden bg-white border-y border-gray-100">
    <!-- Motif de fond discret -->
    <div class="absolute right-0 top-0 w-1/3 h-full bg-gradient-to-bl from-blue-50/40 to-transparent -z-10 transform skew-x-12 translate-x-1/2"></div>
    <div class="absolute left-0 bottom-0 w-1/4 h-3/4 bg-gradient-to-tr from-emerald-50/40 to-transparent -z-10 rounded-tr-full"></div>

    <div class="max-w-4xl mx-auto px-6" x-data="quizModule({{ $activeQuiz->questions->toJson() }})">
        
        <!-- En-tête du Quiz "Le Défi PEP" -->
        <div class="text-center mb-12" x-show="!finished">
            <span class="inline-flex items-center gap-2 px-3 py-1 mb-4 text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Le Défi PEP
            </span>
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-pep-dark mb-4">
                {{ $activeQuiz->title }}
            </h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto mb-2">
                {{ $activeQuiz->description ?: 'Prenez quelques minutes pour tester vos bons réflexes et affiner votre expertise.' }}
            </p>
            
            <div class="w-full max-w-md mx-auto bg-gray-100 rounded-full h-1 mt-8 mb-2 overflow-hidden">
                <div class="bg-pep-dark h-1 rounded-full transition-all duration-500 ease-out" 
                     :style="'width: ' + ((currentQuestion) / totalQuestions * 100) + '%'"></div>
            </div>
            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest text-center">
                Question <span x-text="currentQuestion + 1" class="text-pep-dark"></span> / <span x-text="totalQuestions"></span>
                <span class="mx-2 text-gray-300">|</span>
                Univers : <span class="text-blue-600">{{ $activeQuiz->category }}</span>
            </div>
        </div>

        <!-- Carte de Question Actuelle -->
        <div x-show="!finished" class="bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] rounded-3xl p-8 md:p-12 relative transition-all duration-500 transform" :class="{'scale-95 opacity-50 pointer-events-none': transition}">
            
            <h3 class="text-2xl md:text-3xl font-bold text-pep-dark mb-10 leading-relaxed text-center" x-text="getCurrentQuestion().question_text"></h3>

            <!-- Options -->
            <div class="space-y-4 max-w-3xl mx-auto">
                <template x-for="(option, index) in getCurrentQuestion().options" :key="index">
                    <button 
                        @click="selectOption(index)"
                        :disabled="showExplanation"
                        class="w-full text-left p-5 md:p-6 rounded-2xl border-2 transition-all duration-300 relative overflow-hidden group flex items-center justify-between"
                        :class="{
                            'border-gray-50 hover:border-blue-100 hover:bg-blue-50/30 hover:shadow-md bg-white': !showExplanation,
                            'border-emerald-500 bg-emerald-50 text-emerald-900 shadow-inner ring-4 ring-emerald-500/10': showExplanation && option.is_correct,
                            'border-red-200 bg-red-50 text-red-900 opacity-60': showExplanation && selectedIndex === index && !option.is_correct,
                            'border-gray-50 bg-gray-50/50 opacity-40': showExplanation && !option.is_correct && selectedIndex !== index
                        }"
                    >
                        <span class="font-medium text-lg relative z-10" x-text="option.text"></span>
                        
                        <!-- Icônes de validation -->
                        <div x-show="showExplanation" class="relative z-10 transition-all duration-500">
                            <svg x-show="option.is_correct" class="w-6 h-6 text-emerald-600 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <svg x-show="!option.is_correct && selectedIndex === index" class="w-6 h-6 text-red-500 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                    </button>
                </template>
            </div>

            <!-- Explication & Bouton Suivant -->
            <div x-show="showExplanation" 
                 x-transition:enter="transition ease-out duration-500 delay-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="mt-10 pt-8 border-t border-gray-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8 bg-gray-50/50 rounded-2xl p-6 border border-gray-100/50">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600">Le saviez-vous ?</span>
                        </div>
                        <p class="text-gray-600 text-sm italic leading-relaxed" x-text="getCurrentQuestion().explanation || 'Très bien joué !'"></p>
                    </div>
                    <button @click="nextQuestion()" class="bg-pep-dark text-white px-8 py-4 rounded-xl font-bold hover:bg-black transition-all flex-shrink-0 flex items-center justify-center transform hover:-translate-y-1 shadow-lg group">
                        Suivant <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Écran de Résultat -->
        <div x-cloak x-show="finished" class="bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-3xl p-12 md:p-16 text-center max-w-2xl mx-auto transform transition-all duration-700"
             x-transition:enter="ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <div class="relative inline-block mb-10">
                <div class="absolute inset-0 bg-emerald-100 rounded-full blur-xl opacity-60 animate-pulse"></div>
                <div class="relative inline-flex items-center justify-center w-28 h-28 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 shadow-inner border border-emerald-200/50">
                    <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
            </div>
            
            <h3 class="text-4xl font-serif font-bold text-pep-dark mb-4">Quiz terminé !</h3>
            <p class="text-xl text-gray-500 mb-8">Votre score d'expertise : <br/><span class="font-black text-emerald-600 text-6xl block mt-4" x-text="score + ' / ' + totalQuestions"></span></p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-12">
                <button @click="restart()" class="bg-gray-50 text-pep-dark px-8 py-4 rounded-xl font-bold hover:bg-gray-100 border border-gray-200 transition-all cursor-pointer">Rejouer le défi</button>
                <a href="{{ route('blog.index', ['category' => $activeQuiz->category]) }}" class="bg-pep-dark text-white px-8 py-4 rounded-xl font-bold hover:bg-pep-accent transition-all shadow-lg hover:-translate-y-1 transform">Approfondir ce sujet</a>
            </div>
        </div>
        
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('quizModule', (questions) => ({
                questions: questions,
                currentQuestion: 0,
                totalQuestions: questions.length,
                showExplanation: false,
                selectedIndex: null,
                score: 0,
                finished: false,
                transition: false,

                getCurrentQuestion() {
                    return this.questions[this.currentQuestion];
                },
                selectOption(index) {
                    if (this.showExplanation) return;
                    this.selectedIndex = index;
                    this.showExplanation = true;
                    if (this.getCurrentQuestion().options[index].is_correct) {
                        this.score++;
                    }
                },
                nextQuestion() {
                    this.transition = true;
                    setTimeout(() => {
                        this.currentQuestion++;
                        this.showExplanation = false;
                        this.selectedIndex = null;
                        if (this.currentQuestion >= this.totalQuestions) {
                            this.finished = true;
                        }
                        this.transition = false;
                    }, 400);
                },
                restart() {
                    this.currentQuestion = 0;
                    this.showExplanation = false;
                    this.selectedIndex = null;
                    this.score = 0;
                    this.finished = false;
                    this.transition = false;
                }
            }))
        })
    </script>
</section>
@endif
