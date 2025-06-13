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
</head>

<body class="bg-light-gray">
    @include('layouts.navigation')
    <main class="py-4">
        <section class="container mx-auto px-4 pt-[70px]">
            @if (session('success'))
                <x-message-with type="success" :message="session('success')" />
            @endif

            {{-- Mensagem de erro --}}
            @if (session('error'))
                <x-message-with type="error" :message="session('error')" />
            @endif


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-xl shadow-xl p-6 md:p-8">
                <div>
                    <x-carrossel-imagens :imageUrl="$bem->imageUrl" :modelo="$bem->modelo" altura_miniaturas="h-56" />
                </div>

                
                <!-- Informações e Formulário -->
                <div class="space-y-2 bg-white p-6 rounded-xl shadow-lg">
                    <div>
                        <div class="grid grid-cols-6 gap-2">
                            <div class="col-span-4">

                                <h1 class="text-4xl md:text-5xl font-bold text-primary-blue">{{ $bem->modelo }}</h1>
                            </div>
                            <div class="col-span-2">
                                <p class="text-lg text-gray-600 mt-2 font-semibold">
                                    {{ $bem->preco_diario }}€/por dia</p>
                            </div>
                        </div>
                        <p class="text-xl text-gray-600 mt-2">{{ $bem->filial }}, {{ $bem->posicao }},
                            {{ $bem->cidade }}</p>
                    </div>


    <div>

                        <h3 class="text-2xl font-bold text-primary-blue">Destaques</h3>
                        <ul class="mt-1 grid grid-cols-2 gap-2">
                            @foreach ($caracteristicas as $caracteristica)
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-orange-dark" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $caracteristica }}
                                </li>
                            @endforeach
                        </ul>
                         <p class="mt-2 text-dark-gray opacity-90 leading-relaxed">
                            {{ $bem->marca_obs ?? 'Nenhuma descrição disponível para este veículo.' }}</p>
                    </div>

                    <!-- Formulário -->
                    <form id="form_reserva" method="POST" action="{{ route('pagamento.iniciar') }}">
                        @csrf

                        <div class="space-y-4">
<div class="flex items-center space-x-4">                                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" id="name" name="name" value="{{ ucwords($user->name) }}"
                                    readonly
                                    class="mt-1 block w-full rounded-md border-primary-blue shadow-sm focus:border-orange-dark focus:ring-orange-dark sm:text-sm p-2 bg-gray-100 text-gray-700">
                            </div>

                            <div class="flex items-center space-x-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" readonly
                                    class="mt-1 block w-full rounded-md border-primary-bluet shadow-sm focus:border-orange-dark focus:ring-orange-dark sm:text-sm p-2 bg-gray-100 text-gray-700">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de
                                        Levantamento</label>
                                    <input type="date" id="data_inicio" name="data_inicio" required
                                        value="{{ $possivel_reserva['data_inicio'] ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-dark focus:ring-orange-dark sm:text-sm p-2 border">
                                </div>
                                <div>
                                    <label for="data_fim" class="block text-sm font-medium text-gray-700">Data
                                        de
                                        Entrega</label>
                                    <input type="date" id="data_fim" name="data_fim" required
                                        value="{{ $possivel_reserva['data_fim'] ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-dark focus:ring-orange-dark sm:text-sm p-2 border">
                                </div>
                            </div>
                        </div>

                        <div id="preco_total_container" class="text-lg font-semibold text-orange-dark mt-4">
                            Total: <span id="preco_total">0</span>€
                        </div>

                        <input type="hidden" name="tipo_pagamento" id="tipo_pagamento" value="">

                        <!-- Botões de pagamento -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opções de
                                Pagamento</label>
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" id="btn_pagar_paypal"
                                    class="bg-primary-blue text-white px-4 py-2 rounded-lg hover:bg-orange-light transition focus:outline-none focus:ring-2 focus:ring-orange-light focus:ring-offset-2 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106z" />
                                    </svg>
                                    <span>PayPal</span>
                                </button>

                                <button type="button" id="btn_simular_multibanco"
                                    class="bg-primary-blue text-white px-4 py-2 rounded-lg hover:bg-orange-light transition focus:outline-none focus:ring-2 focus:ring-orange-light focus:ring-offset-2 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                    </svg>
                                    <span>Referência Multibanco</span>
                                </button>
                            </div>
                        </div>

                        <!-- Loading -->
                        <div id="loading" class="hidden mt-4 text-center">
                            <div
                                class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-orange-dark transition ease-in-out duration-150 cursor-not-allowed">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processando...
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </main>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dataInicio = document.getElementById('data_inicio');
            const dataFim = document.getElementById('data_fim');
            const precoTotalEl = document.getElementById('preco_total');
            const precoDiaria = {{ $bem->preco_diario }};
            const form = document.getElementById('form_reserva');
            const tipoPagamentoInput = document.getElementById('tipo_pagamento');
            const btnPaypal = document.getElementById('btn_pagar_paypal');
            const btnMultibanco = document.getElementById('btn_simular_multibanco');
            const loading = document.getElementById('loading');

            const hoje = new Date().toISOString().split("T")[0];
            dataInicio.min = hoje;

            function validarDatas() {
                const inicio = new Date(dataInicio.value);
                const hojeDate = new Date().setHours(0, 0, 0, 0);

                if (inicio < hojeDate) {
                    alert("A data de início não pode estar no passado.");
                    dataInicio.value = '';
                    dataFim.value = '';
                    precoTotalEl.textContent = '0';
                    return;
                }

                const minFim = new Date(inicio);
                minFim.setDate(minFim.getDate() + 1);
                dataFim.min = minFim.toISOString().split("T")[0];

                if (!dataFim.value || new Date(dataFim.value) < minFim) {
                    dataFim.value = dataFim.min;
                }
                calcularPrecoTotal();

            }

            function calcularPrecoTotal() {
                if (!dataInicio.value || !dataFim.value) {
                    precoTotalEl.textContent = '0';
                    return;
                }

                const inicio = new Date(dataInicio.value);
                const fim = new Date(dataFim.value);
                if (fim <= inicio) {
                    precoTotalEl.textContent = '0';
                    return;
                }

                const diffDias = Math.ceil((fim - inicio) / (1000 * 60 * 60 * 24));
                const total = (diffDias * precoDiaria) + precoDiaria;
                precoTotalEl.textContent = total.toFixed(2);
            }

            function validarFormulario() {
                if (!dataInicio.value || !dataFim.value) {
                    alert('Por favor, selecione as datas de início e fim.');
                    return false;
                }
                if (new Date(dataInicio.value) >= new Date(dataFim.value)) {
                    alert('A data de fim deve ser posterior à de início.');
                    return false;
                }
                return true;
            }

            function prepararPagamento(tipo) {
                if (!validarFormulario()) return;
                tipoPagamentoInput.value = tipo;
                form.action = "{{ route('pagamento.iniciar') }}";
                loading.classList.remove('hidden');
                btnPaypal.disabled = btnMultibanco.disabled = true;
                form.requestSubmit();
            }

            btnPaypal.addEventListener('click', function(e) {
                e.preventDefault();
                prepararPagamento('paypal');
            });

            btnMultibanco.addEventListener('click', function(e) {
                e.preventDefault();
                prepararPagamento('multibanco');
            });



            [dataInicio, dataFim].forEach(input => {
                input.addEventListener('change', () => {
                    validarDatas();
                    calcularPrecoTotal();
                });
            });

            calcularPrecoTotal();
        });
    </script>
</body>
</section>
</main>

</html>
