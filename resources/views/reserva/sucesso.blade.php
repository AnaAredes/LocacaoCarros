<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Reservada</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Notificacao de sucesso -->
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-lg animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">Transação concluída com sucesso!</p>
                </div>
            </div>
        </div>

        <!-- Updated: Main content card with enhanced styling -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-dark to-orange-light px-6 py-8 text-beige-light">
                <h2 class="text-3xl font-bold text-center">Pagamento Confirmado</h2>
                <p class="text-center mt-2 text-beige-light">Sua transação foi processada com sucesso</p>
            </div>

            <!-- Added: Transaction details section -->
            <div class="p-6 space-y-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-sm text-gray-500">Valor Pago</div>
                        <div class="text-sm font-medium text-gray-900">{{ $amount }}</div>
                        <div class="text-sm text-gray-500">Nome do Pagador</div>
                        <div class="text-sm font-medium text-gray-900">{{ $payerName }}</div>
                        <div class="text-sm text-gray-500">Data da Transação</div>
                        <div class="text-sm font-medium text-gray-900">{{ date('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <!-- botoes -->
                <div class="space-y-4">
                    <a href="{{ route('reserva.print') }}"
                        class="block w-full bg-purple-dark text-white text-center py-3 px-4 rounded-lg hover:bg-purple-light transition duration-150 ease-in-out">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Descarregar Reserva (PDF)
                        </div>
                    </a>

                    <a href="/"
                        class="block w-full bg-gray-100 text-gray-700 text-center py-3 px-4 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                        Voltar para Página Inicial
                    </a>
                </div>
            </div>
        </div>

        <a href="{{ route('send.emailsucesso') }}" target="_blank"
            class="w-full bg-purple-dark hover:bg-purple-light text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <span class="text-center text-sm">Quero receber o comprovante por email</span>
        </a>
    </div>

    <!-- animacao -->
    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }
    </style>
</body>

</html>
