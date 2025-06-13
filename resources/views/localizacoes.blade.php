<!-- JS: chamo app.js pelo import (vite(['resources/js/app.js'])).
Se optasse por guardar na pasta public/js, poderia chamar pelo assets
ex.:  <script src="{ asset('js/modal.js') }}"></script> #com uma chaveta antes do asset
    <script src="{ asset('js/filtro-data.js') }}"></script> #com uma chaveta antes do asset
-->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros em Destaque</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="beige-light">
    @include('layouts.navigation')
    <main>
        <!-- Barra de filtro -->
        <section class="container mx-auto px-4 pt-[70px]">
            <div class="bg-white shadow-xl rounded-lg p-6 mb-8 border border-gray-100">
                <form action="{{ route('localizacao', ['cidades' => implode(',', $cidades)]) }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">

                    <!-- Data de Levantamento -->
                    <div>
                        <label for="data_inicio" class="block text-sm font-semibold text-dark-gray mb-1">
                            <span class="mr-2">📅</span>Levantamento
                        </label>
                        <input type="date" id="data_inicio" name="data_inicio" value="{{ request('data_inicio') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-blue focus:border-primary-blue shadow-sm"
                            required>
                    </div>

                    <!-- Data de Entrega -->
                    <div>
                        <label for="data_fim" class="block text-sm font-semibold text-dark-gray mb-1">
                            <span class="mr-2">📆</span>Entrega
                        </label>
                        <input type="date" id="data_fim" name="data_fim" value="{{ request('data_fim') }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-blue focus:border-primary-blue shadow-sm"
                            required>
                    </div>

                    <!-- Preço -->
                    <div>
                        <label for="preco" class="block text-sm font-semibold text-dark-gray mb-1">
                            <span class="mr-2">👥</span>Valor da Diária
                        </label>
                        <select id="preco" name="preco"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-blue focus:border-primary-blue shadow-sm">
                            <option value="">Selecione um intervalo de preço</option>
                            <option value="40-55">€40 - €55</option>
                            <option value="55-70">€55 - €70</option>
                            <option value="70-85">€70 - €85</option>
                            <option value="85+">Mais de €85</option>
                        </select>
                    </div>

                    <!-- Botão de Pesquisa -->
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full flex items-center justify-center bg-primary-blue hover:bg-indigo-700 text-text-light font-bold px-6 py-2.5 rounded-md transition duration-300 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Pesquisar Viaturas
                        </button>
                    </div>
            </div>

            </form>
            </div>
        </section>

        @if (session('error'))
            <div
                class="alert alert-error shadow-lg rounded-lg py-4 px-6 font-semibold text-red-800 bg-red-100 ring-1 ring-red-300 flex items-center space-x-2">
                <svg class="w-6 h-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M4.93 4.93a10 10 0 0114.14 0m0 14.14a10 10 0 01-14.14 0m14.14-14.14a10 10 0 00-14.14 0m14.14 14.14a10 10 0 01-14.14 0" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif


        <!-- Seção de listagem de cidades / localização específica -->
        <section>
            <div class="container mx-auto px-4 py-8">

                {{-- A lógica para exibir cidades (o bloco que você forneceu) --}}
                @if (empty($cidades))
                    <div class="text-center text-gray-600 p-8 bg-white rounded-lg shadow-md">
                        <p class="text-lg">Não há localizações disponíveis no momento.</p>
                        <p class="mt-2 text-md">Por favor, verifique mais tarde ou entre em contato connosco.</p>
                    </div>
                @else
                    @if (count($cidades) === 1)
                        {{-- Caso haja apenas uma cidade (vindo de /localizacao/{cidade}) --}}
                        <div class="flex justify-center mb-4">
                            <h2 class="text-3xl md:text-4xl font-bold text-accent-orange mb-4">
                                Filial: {{ $cidades[0] }}
                            </h2>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                            @foreach ($cidades as $cidade)
                                <div class="bg-white rounded-xl p-6 text-center">
                                    <h1 class="text-3xl font-bold text-gray-800">{{ $cidade }}</h1>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                @if ($bens->isEmpty())
                    <div class="text-center text-gray-600">Não há propriedades disponíveis para as datas e localização
                        selecionadas</div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6">
                        @foreach ($bens as $bem)
                            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer group"
                                onclick="openModal({{ $bem->id }})" role="button" tabindex="0">
                                <!-- Imagem da Viatura -->
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ $bem->imageUrl ?? 'https://images.unsplash.com/photo-1582298964726-281b7a2d4b97?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                        alt="{{ $bem->modelo }}"
                                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1520625399587-8d071a7428f7?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';"
                                        loading="lazy">
                                    {{-- A imagem de fallback agora é um carro mais genérico --}}
                                </div>

                                <!-- Detalhes do Carro -->
                                <div class="p-5">
                                    <h3 class="text-2xl font-bold text-primary-blue mb-2">{{ $bem->modelo }}</h3>
                                    <!-- Características Rápidas -->
                                    <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-sm text-gray-700 mb-4">
                                        <div class="flex items-center">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5 text-accent-orange mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                            </svg>

                                            <span>{{ $bem->numero_passageiros }} Passageiros</span>
                                        </div>
                                        @if ($bem->transmissao)
                                            {{-- Exemplo: se tiver campo transmissao --}}
                                            <div class="flex items-center">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 text-accent-orange mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                                </svg>

                                                <span>{{ $bem->transmissao == 'automática' ? 'Automático' : 'Manual' }}</span>
                                            </div>
                                        @endif

                                    </div>

                                    <!-- Preço e Botão de Ação -->
                                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                                        <div class="text-xl font-bold text-accent-orange">
                                            {{ number_format($bem->preco_diario, 2, ',', '.') }} € <span
                                                class="text-sm font-normal text-gray-500">/dia</span>
                                        </div>
                                        <button onclick="openModal({{ $bem->id }})"
                                            class="bg-primary-blue hover:bg-indigo-700 text-text-light px-6 py-2 rounded-full font-semibold transition duration-300 shadow-md">
                                            Ver Detalhes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Modal -->
        <div id="propertyModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 hidden">
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-all duration-300 ease-out">
                <!-- Cabeçalho do Modal -->
                <div class="relative">
                    <!-- Imagem Principal do Carro -->
                    <img id="modalImagem"
                        src="https://images.unsplash.com/photo-1520625399587-8d071a7428f7?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Imagem da Viatura" class="w-full h-64 md:h-80 object-cover rounded-t-xl">

                    <!-- Botão de Fechar -->
                    <button onclick="closeModal()"
                        class="absolute top-4 right-4 bg-dark-gray/70 text-text-light rounded-full p-2 hover:bg-dark-gray transition duration-300 focus:outline-none focus:ring-2 focus:ring-accent-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Conteúdo do Modal -->
                <div class="p-6 md:p-8">
                    <h2 id="modalTitulo" class="text-3xl md:text-4xl font-bold text-primary-blue mb-4"></h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-dark-gray mb-6">
                        <!-- Passageiros -->
                        <div class="flex items-center text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-accent-orange mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span id="modalPassageiros" class="font-open-sans"></span>
                        </div>
                        <!-- Combustível -->
                        <div class="flex items-center text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6 text-accent-orange mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>

                            <span id="modalCombustivel" class="font-open-sans"></span>
                        </div>
                        <!-- Transmissão -->
                        <div class="flex items-center text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-accent-orange mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                            </svg>
                            <span id="modalTransmissao" class="font-open-sans"></span>
                        </div>
                    </div>

                    <div
                        class="flex flex-col md:flex-row justify-between items-center border-t border-gray-200 pt-6 mt-6">
                        <div class="text-3xl font-bold text-accent-orange mb-4 md:mb-0">
                            <span id="modalPreco">99,99 € <span class="text-sm font-normal text-gray-600">/por
                                    dia</span></span>
                        </div>
                        <button onclick="verDetalhes()"
                            class="bg-primary-blue hover:bg-indigo-700 text-text-light px-8 py-3 rounded-full font-bold transition duration-300 shadow-lg flex items-center justify-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <span>Alugar Agora</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <script>
        window.properties = @json($bens);
    </script>
</body>

</html>
