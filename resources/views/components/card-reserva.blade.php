<div class="flex w-full items-center justify-center p-4">
    <div class="w-full bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
       <!-- Imagem do Veículo -->
        <div class="relative h-64 sm:h-80 overflow-hidden">
            <img src="{{ $bem->imageUrl }} ?? 'https://images.unsplash.com/photo-1525609002-ab340263897e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                class="w-full h-full object-cover object-center rounded-t-xl transition duration-300 transform group-hover:scale-105">
            <div class="absolute inset-0 bg-primary-blue/30"></div>
        </div>

        <div class="p-4 space-y-6">
            <!-- Título e Status -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <h2 class="text-3xl font-bold text-primary-blue mb-2 sm:mb-0">{{ $bem->modelo }}</h2>
                <span
                    class="bg-accent-orange text-text-light font-semibold px-4 py-1 rounded-full text-base shadow-md">
                    Reserva Confirmada
                </span>
            </div>

            <!-- Detalhes da Reserva -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-4 gap-x-6">
                <!-- Data de Levantamento -->
                <div>
                    <p class="text-gray-600 text-sm mb-1">Levantamento:</p>
                    <div class="flex items-center text-text-dark font-semibold text-lg">
                        <svg class="w-6 h-6 text-primary-blue mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($bem->data_inicio)->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}
                    </div>
                </div>

                <!-- Data de Entrega -->
                <div>
                    <p class="text-gray-600 text-sm mb-1">Entrega:</p>
                    <div class="flex items-center text-text-dark font-semibold text-lg">
                        <svg class="w-6 h-6 text-primary-blue mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($bem->data_fim)->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}
                    </div>
                </div>

                <!-- Localização -->
                <div>
                    <p class="text-gray-600 text-sm mb-1">Localização:</p>
                    <div class="flex items-center text-text-dark font-semibold text-lg">
                        <svg class="w-6 h-6 text-primary-blue mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        {{ $bem->cidade }}
                    </div>
                </div>

                <!-- Características (Ajuste o layout se houver muitas) -->
                <div class="col-span-3">
                    <p class="text-gray-600 text-sm mb-2">Características:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($caracteristicas as $caracteristica)
                            <span
                                class="px-4 py-1 bg-light-gray text-primary-blue font-medium rounded-full text-sm shadow-sm">
                                {{ $caracteristica }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Separador -->
            <hr class="border-t border-gray-200 my-4">

            <!-- Preço Total -->
            <div class="flex justify-between items-center bg-light-gray p-4 rounded-lg">
                <div class="text-gray-700 font-semibold text-lg">Total Pago:</div>
                <div class="text-4xl font-extrabold text-primary-blue">
                    {{ number_format(\Carbon\Carbon::parse($bem->data_inicio)->diffInDays(\Carbon\Carbon::parse($bem->data_fim)) * $bem->preco_diario, 2, ',', '.') }}€
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <a href="{{ route('descarregar', $bem->reserva_id) }}"
                    class="w-full sm:w-1/2 bg-primary-blue hover:bg-dark-gray text-text-light font-bold py-4 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center gap-2 shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Gerar PDF
                </a>

                <a href="{{ route('send.emailconfirmacao', ['reserva_id' => $bem->reserva_id]) }}" target="_blank"
                    class="w-full sm:w-1/2 bg-accent-orange hover:bg-orange-600 text-text-light font-bold py-4 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center gap-2 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Enviar por E-mail
                </a>
            </div>
        </div>
    </div>
</div>