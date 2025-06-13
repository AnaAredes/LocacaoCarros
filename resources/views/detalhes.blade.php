<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $bem->modelo }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

<body class="bg-light-gray">
    @include('layouts.navigation')

    <main class="py-8">
        <section class="container mx-auto px-4 pt-[70px]">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-xl shadow-xl p-6 md:p-8">

                <div>
                    <x-carrossel-imagens :imageUrl="$bem->imageUrl" :modelo="$bem->modelo" altura_miniaturas="h-24"/>                
                </div>

                <div class="space-y-6">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-primary-blue">{{ $bem->modelo }}</h1>
                        <p class="text-lg text-gray-600 mt-2">
                            <span class="font-semibold">{{ $bem->cidade }}</span>, {{ $bem->filial }} -
                            {{ $bem->posicao }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-y-4 gap-x-6">
                        <x-info-box :data="$bem->transmissao" text="">
                            🕹️
                        </x-info-box>

                        <x-info-box :data="$bem->combustivel" text="">
                            ⛽
                        </x-info-box>

                        <x-info-box :data="$bem->cor" text="">
                            🎨
                        </x-info-box>

                        <!--
  <x-info-box :data="$bem->numero_passageiros" text="passageiros">
                            👥
                        </x-info-box>Miniaturas -->
                    </div>


                    <!-- Seção de Descrição -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-primary-blue">Sobre este veículo</h2>
                        <p class="text-dark-gray opacity-90 leading-relaxed">
                            {{ $bem->marca_obs ?? 'Nenhuma descrição disponível para este veículo.' }}</p>
                        {{-- Assumi que 'observacao' é o campo de texto longo para detalhes --}}
                    </div>
                    <!-- Seção de Características Listadas -->
                    <div class="space-y-4">
                        <ul class="grid grid-cols-2 gap-4">
                            @foreach ($caracteristicas as $caracteristica)
                                <li class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-3 text-accent-orange">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $caracteristica }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div
                        class="border-t border-gray-200 pt-6 mt-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-4xl font-bold text-accent-orange mb-4 sm:mb-0">
                            {{ number_format($bem->preco_diario, 2, ',', '.') }} € <span
                                class="text-lg font-normal text-gray-500">/dia</span>
                        </div>
                        <a href="{{ route('reserva.index') }}"
                            class="bg-primary-blue hover:bg-indigo-700 text-text-light px-10 py-4 rounded-full font-bold transition duration-300 shadow-lg flex items-center justify-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>

                            <span>Reservar Agora</span>
                        </a>
                    </div>

                </div>
            </div>

        </section>

    </main>

</body>

</html>
