<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rota Certa: Aluguer de Carros</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <!-- Remova '300' para um visual mais forte, se quiser -->

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            color: #222222;
            /* text-dark */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="bg-light-gray text-text-dark">
    @include('layouts.navigation')

    <main>
        <!-- Seção de Cidades (Atualizada para um look mais limpo e vibrante) -->
        <section class="container mx-auto px-4 py-16">
            <h1 class="text-3xl text-center md:text-6xl font-bold mt-12 mb-4 leading-tight text-primary-blue">
                Alugue o carro perfeito para a sua próxima aventura.
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Bloco 1 (Lisboa) -->
                <a href="{{ route('localizacao', ['cidades' => 'Lisboa']) }}" class="block group">
                    <div
                        class="relative overflow-hidden rounded-xl shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <!-- Imagem -->
                        <img src="https://images.unsplash.com/photo-1640508080247-c8de94da4d24?q=80&w=1920&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Lisboa"
                            class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
                        <!-- Overlay azul -->
                        <div
                            class="absolute inset-0 bg-primary-blue/60 group-hover:bg-transparent transition duration-300 z-10">
                        </div>
                        <!-- Texto por cima -->
                        <div class="absolute inset-0 flex items-end p-6 z-20">
                            <div class="text-text-light">
                                <h3 class="text-2xl font-bold mb-1">Lisboa</h3>
                                <p class="opacity-90 font-open-sans text-sm">Unidade Lisboa Aeroporto</p>
                            </div>
                        </div>
                    </div>
                </a>


                <!-- Bloco 2 (Braga) -->
                <a href="{{ route('localizacao', ['cidades' => 'Braga']) }}" class="block group">
                    <div
                        class="relative overflow-hidden rounded-xl shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1553476685-5274087fb6ad?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Braga"
                            class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
                        <!-- Overlay azul -->
                        <div
                            class="absolute inset-0 bg-primary-blue/60 group-hover:bg-transparent transition duration-300 z-10">
                        </div>
                        <!-- Texto por cima -->
                        <div class="absolute inset-0 flex items-end p-6 z-20">
                            <div class="text-text-light">
                                <h3 class="text-2xl font-bold mb-1">Braga</h3>
                                <p class="opacity-90 font-open-sans text-sm">Unidade Braga Centro e Nogueira</p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- Bloco 3 (Porto) -->
                <a href="{{ route('localizacao', ['cidades' => 'Porto']) }}" class="block group">
                    <div
                        class="relative overflow-hidden rounded-xl shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <img src="https://plus.unsplash.com/premium_photo-1677344087971-91eee10dfeb1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Porto"
                            class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
                        <!-- Overlay azul -->
                        <div
                            class="absolute inset-0 bg-primary-blue/60 group-hover:bg-transparent transition duration-300 z-10">
                        </div>
                        <!-- Texto por cima -->
                        <div class="absolute inset-0 flex items-end p-6 z-20">
                            <div class="text-text-light">
                                <h3 class="text-2xl font-bold mb-1">Porto</h3>
                                <p class="opacity-90 font-open-sans text-sm">Unidade Porto Centro</p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- Bloco 4 (Coimbra) -->
                <a href="{{ route('localizacao', ['cidades' => 'Coimbra']) }}" class="block group">
                    <div
                        class="relative overflow-hidden rounded-xl shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1696067927196-113219ba1486?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Coimbra"
                            class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
                        <!-- Overlay azul -->
                        <div
                            class="absolute inset-0 bg-primary-blue/60 group-hover:bg-transparent transition duration-300 z-10">
                        </div>
                        <!-- Texto por cima -->
                        <div class="absolute inset-0 flex items-end p-6 z-20">
                            <div class="text-text-light">
                                <h3 class="text-2xl font-bold mb-1">Coimbra</h3>
                                <p class="opacity-90 font-open-sans text-sm">Unidade Coimbra Estação</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Seção de "Por Que Escolher-nos?" - Facilidade e Praticidade -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-12 text-primary-blue">Porquê Escolher a Rota Certa?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-accent-orange mb-4">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061A1.125 1.125 0 0 1 3 16.811V8.69ZM12.75 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061a1.125 1.125 0 0 1-1.683-.977V8.69Z" />
                            </svg>

                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-primary-blue">Processo Simplificado</h3>
                    </div>
                    <div class="p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-accent-orange mb-4">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                            </svg>

                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-primary-blue">Frota Diversificada</h3>
                    </div>
                    <div class="p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-accent-orange mb-4">


                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>

                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-primary-blue">Localização Conveniente</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Todos -->
        <section class="relative h-[30vh] md:h-[50vh] flex items-center justify-center overflow-hidden">
            <img src="https://images.unsplash.com/photo-1521136095380-08fbd7be93c8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Viagem de Carro" class="absolute inset-0 w-full h-full object-cover z-0 filter brightness-75">
            <div class="absolute inset-0 bg-primary-blue/60 z-10"></div>
            <div class="relative z-20 text-center text-text-light px-4 max-w-4xl mx-auto">

                <h2 class="text-3xl md:text-4xl font-bold mb-4">Alugue com facilidade, conduza com liberdade</h2>
                <p class="text-xl md:text-2xl opacity-90 mb-8 font-open-sans">
                    Simples, rápido e sem complicações.
                </p>
                <a href="/disponiveis"
                    class="inline-block bg-accent-orange text-text-light px-10 py-4 rounded-full font-bold
                                              transform hover:scale-105 transition duration-300 shadow-lg">
                    Ver Frota Completa
                </a>

            </div>
        </section>


        <!-- Rodapé - Coerente com a nova paleta -->
        <footer class="bg-dark-gray text-light-gray py-12">
            <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-bold mb-4">Rota Certa</h4>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Filiais</h4>
                    <ul class="space-y-2 text-light-gray opacity-90">
                        <li><a href="{{ route('localizacao', ['cidades' => 'Porto']) }}"
                                class="hover:text-white transition">Unidade Porto Centro</a></li>
                        <li><a href="{{ route('localizacao', ['cidades' => 'Braga']) }}"
                                class="hover:text-white transition">Unidade Braga Centro e Unidade Braga Nogueira</a>
                        </li>
                        <li><a href="{{ route('localizacao', ['cidades' => 'Lisboa']) }}"
                                class="hover:text-white transition">Unidade Lisboa Aeroporto</a></li>
                        <li><a href="{{ route('localizacao', ['cidades' => 'Coimbra']) }}"
                                class="hover:text-white transition">Unidade Coimbra Estação</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Sobre</h4>
                    <ul class="space-y-2 text-light-gray opacity-90">
                        <li><a href="#" class="hover:text-white transition">Nossa História</a></li>
                        <li><a href="#" class="hover:text-white transition">Contato</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </main>
</body>

</html>
