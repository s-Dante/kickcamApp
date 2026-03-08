<x-app>
    <x-slot:title>Bienvenido</x-slot:title>

    @push('css')
        <style>
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-20px) rotate(5deg);
                }
            }

            .animate-float-slow {
                animation: float 8s ease-in-out infinite;
            }

            .animate-float-medium {
                animation: float 6s ease-in-out infinite;
                animation-delay: 1s;
            }
        </style>
    @endpush

    @php
        $balls = [
            // Esquina superior izquierda
            ['src' => asset('assets/wc-balls/2022.png'), 'class' => 'top-[-5%] left-[-5%] md:top-[-3%] md:left-[2%] w-[17rem] md:w-[18.5rem] animate-float-slow'],
            // Esquina inferior derecha
            ['src' => asset('assets/wc-balls/2018.png'), 'class' => 'bottom-[30%] right-[-15%] md:bottom-[2%] md:right-[2%] w-[25rem] md:w-[31.75rem] animate-float-medium'],
            // Medio izquierda
            ['src' => asset('assets/wc-balls/2014.png'), 'class' => 'bottom-[5%] left-[3%] md:bottom-[10%] md:left-[21%] w-[13.5rem] md:w-[14.25rem] blur-[1px]'],
            // Medio derecha arriba
            ['src' => asset('assets/wc-balls/2010.png'), 'class' => 'top-[10%] right-[4%] md:right-[24%] w-40 md:w-[12.5rem] blur-[2px]'],
        ];

        $styles = [
            'pageContainer' => 'min-h-[100dvh] w-full relative overflow-hidden flex flex-col justify-center bg-radial-1 text-secondary selection:bg-accent selection:text-white px-6 sm:px-10 lg:px-20',
            'backgroundLayer' => 'absolute inset-0 w-full h-full z-0 overflow-hidden pointer-events-none select-none',
            'ball' => 'absolute opacity-20 md:opacity-40 pointer-events-none transition-all duration-700',
            'contentWrapper' => 'relative z-10 flex flex-col items-center md:items-start text-center md:text-left space-y-6 max-w-4xl w-full mx-auto md:mx-0',
            'title' => 'font-sans text-6xl md:text-7xl lg:text-8xl font-extrabold tracking-tight leading-[1.1] text-secondary-sat',
            'subtitle' => 'text-secondary-desat text-lg md:text-xl font-medium max-w-xl',
            'ctaButton' => 'inline-flex items-center justify-center px-10 py-5 text-lg font-semibold rounded-full bg-accent text-white hover:bg-accent-sat transition-all shadow-2xl hover:-translate-y-1 hover:cursor-pointer uppercase tracking-widest'
        ];
    @endphp

    <div class="{{ $styles['pageContainer'] }}">

        <div class="{{ $styles['backgroundLayer'] }}">
            @foreach ($balls as $ball)
                <img src="{{ $ball['src'] }}" class="{{ $styles['ball'] }} {{ $ball['class'] }}" alt="Balón Mundial" />
            @endforeach
        </div>

        <section class="{{ $styles['contentWrapper'] }}">
            <h1 class="{{ $styles['title'] }}">
                El Mundial <br class="md:hidden" />
                en un mismo lugar
            </h1>

            <p class="{{ $styles['subtitle'] }}">
                La experiencia definitiva de realidad aumentada para fanáticos del fútbol.
            </p>

            @auth
                <a href="{{ route('dashboard') }}" class="{{ $styles['ctaButton'] }}">
                    Ir a mi Perfil
                </a>
            @else
                <a href="{{ route('login') }}" class="{{ $styles['ctaButton'] }}">
                    Comenzar Ahora
                </a>
            @endauth
        </section>

    </div>
</x-app>