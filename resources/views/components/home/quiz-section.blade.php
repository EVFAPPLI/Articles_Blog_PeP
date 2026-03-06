<style>
    [x-cloak] { display: none !important; }
</style>

<!-- Quiz Interactif PEP (IA Powered) -->
@if(isset($activeQuiz) && $activeQuiz->questions->count() > 0)
<script>
    window.pepQuizData = @json($activeQuiz->questions);
</script>

<main class="flex-1 w-full max-w-4xl flex flex-col justify-center p-6 md:p-12 pb-20" x-data="quizModule(window.pepQuizData)" x-cloak>
    
    <!-- Zone active du Quiz -->
    <div x-show="!isFinished" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="w-full">
        
        <!-- Progression Discrète -->
        <div class="max-w-xs mx-auto mb-10 text-center">
            <div class="flex justify-between text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">
                <span>{{ $activeQuiz->category ?? 'ESPRIT PEP' }}</span>
                <span><span x-text="currentStep + 1"></span> / <span x-text="questions.length"></span></span>
            </div>
            <div class="h-1 w-full bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full bg-[#00B5AD] transition-all duration-500 ease-out" :style="'width: ' + progress + '%'"></div>
            </div>
        </div>

        <div class="flex flex-col items-center relative transition-all duration-300" :class="{'opacity-0 scale-95': transition, 'opacity-100 scale-100': !transition}">
            
            <!-- Animation SVG Focus -->
            <div class="flex justify-center mb-6">
                <svg width="120" height="40" viewBox="0 0 120 40" class="opacity-80">
                    <circle cx="60" cy="20" r="15" fill="none" stroke="#00B5AD" stroke-width="1" class="animate-[pulse_4s_ease-in-out_infinite]" />
                    <path d="M20,20 Q60,5 100,20 Q60,35 20,20" fill="none" stroke="#00B5AD" stroke-width="0.5" stroke-dasharray="4 4" class="animate-[spin_10s_linear_infinite]" />
                    <circle cx="60" cy="20" r="2" fill="#00B5AD" class="animate-ping" />
                </svg>
            </div>

            <!-- Question text -->
            <h1 class="text-xl md:text-2xl font-serif font-medium text-center text-slate-800 italic mb-8 max-w-2xl" x-text="'&quot;' + currentQuestion?.question_text + '&quot;'"></h1>

            <!-- Réponses Resserrées en Grille -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full mb-10">
                <template x-for="(option, index) in currentQuestion?.options" :key="index">
                    <button
                        @click="handleSelect(index)"
                        class="group relative flex items-center p-4 rounded-xl border transition-all duration-200"
                        :class="selectedOption === index 
                            ? 'border-[#00B5AD] bg-white shadow-md ring-1 ring-[#00B5AD]/20' 
                            : 'border-slate-200 bg-white hover:bg-slate-50'"
                    >
                        <div class="w-4 h-4 rounded-full border-2 mr-3 flex-shrink-0 flex items-center justify-center transition-all"
                             :class="selectedOption === index ? 'border-[#00B5AD] bg-[#00B5AD]' : 'border-slate-300'">
                            <div x-show="selectedOption === index" class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <span class="text-sm font-medium leading-tight text-left"
                              :class="selectedOption === index ? 'text-slate-900' : 'text-slate-600'" x-text="option.text">
                        </span>
                    </button>
                </template>
            </div>

            <!-- Boutons de validation -->
            <div class="flex flex-col items-center gap-4">
                <button
                    @click="handleNext()"
                    :disabled="selectedOption === null"
                    class="group flex items-center gap-2 px-12 py-3 rounded-full font-bold text-sm transition-all focus:outline-none"
                    :class="selectedOption !== null 
                        ? 'bg-slate-900 text-white shadow-lg shadow-black/10 hover:shadow-[#00B5AD]/20 hover:bg-[#00B5AD]' 
                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                >
                    <span x-text="currentStep === questions.length - 1 ? 'Finaliser' : 'Continuer'"></span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest" x-show="selectedOption === null">Appuyez pour valider votre réponse</p>
                <p class="text-[10px] text-[#00B5AD] font-bold uppercase tracking-widest" x-show="selectedOption !== null" x-cloak>RÉPONSE ENREGISTRÉE</p>
            </div>
        </div>
    </div>

    <!-- Écran de Fin / Résultat -->
    <div x-cloak x-show="isFinished" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="w-full max-w-lg mx-auto bg-white p-10 rounded-3xl shadow-xl border border-slate-100 text-center">
        <div class="inline-flex p-3 bg-[#00B5AD]/10 rounded-2xl text-[#00B5AD] mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <h2 class="text-3xl font-serif font-bold text-slate-800 mb-6 italic">Diagnostic Terminé</h2>
        
        <div class="flex justify-center items-baseline gap-1 mb-8 text-slate-900">
            <span class="text-6xl font-black" x-text="Math.round((score/questions.length)*100)"></span>
            <span class="text-xl font-bold text-[#00B5AD]">% d'efficience</span>
        </div>

        <div class="bg-slate-50 p-5 rounded-2xl mb-8 text-left border-l-4 border-[#00B5AD]">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Votre Profil</p>
            <p class="text-sm text-slate-700 italic font-medium leading-relaxed" x-text="score === questions.length ? 'Excellence opérationnelle détectée. Vos réflexes PEP sont optimisés au maximum.' : 'Bonne compréhension globale. Focalisez-vous sur les détails pour optimiser votre efficience.'"></p>
        </div>

        <button @click="window.location.reload()" class="w-full bg-[#00B5AD] text-white py-4 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-[#00B5AD]/30 transition-all flex items-center justify-center gap-2 focus:outline-none">
            Recommencer l'analyse
            <svg class="w-4 h-4 relative top-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </div>

</main> <!-- /x-data -->

<!-- Footer minimaliste -->
<footer class="w-full py-6 flex flex-col items-center bg-transparent mt-auto opacity-70">
    <span class="text-slate-400 text-[9px] font-black uppercase tracking-[0.5em] mb-1">Methodology PEP.uno</span>
    <span class="text-slate-400 text-[8px] font-medium tracking-widest uppercase opacity-70">Think Clear • Act Fast • Lead Better</span>
</footer>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quizModule', (questions) => ({
            questions: questions,
            currentStep: 0,
            selectedOption: null,
            score: 0,
            isFinished: false,
            transition: false,

            get currentQuestion() {
                return this.questions ? this.questions[this.currentStep] : null;
            },
            get progress() {
                return ((this.currentStep + 1) / this.questions.length) * 100;
            },
            handleSelect(index) {
                this.selectedOption = index;
            },
            handleNext() {
                // Check if current answer is correct
                if (this.currentQuestion.options[this.selectedOption].is_correct) {
                    this.score++;
                }
                
                // Go to next or finish
                if (this.currentStep < this.questions.length - 1) {
                    this.transition = true;
                    setTimeout(() => {
                        this.currentStep++;
                        this.selectedOption = null;
                        this.transition = false;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }, 300); // match duration
                } else {
                    this.isFinished = true;
                }
            }
        }))
    })
</script>
@endif
