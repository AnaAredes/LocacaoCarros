<!-- resources/views/bens/index.blade.php -->
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas</title>
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

    <main class="pt-20">

        {{-- Mensagens de Sucesso / Erro --}}
        @if (session('success'))
            <x-message-with type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-message-with type="error" :message="session('error')" />
        @endif

        @if (empty($caracteristicas))
            <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <h1 class="text-3xl font-bold text-purple-dark">Não há reservas</h1>
                    <p class="mt-2 text-purple-dark">Conheça os nossos carros</p>
                </div>
            </div>
        @else
            <div class="py-8 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-primary-blue mb-2 sm:mb-0">Minhas Reservas</h1>
                <p class="text-xl font-bold text-accent-orange mb-2 sm:mb-0 mt-2">
                Veja os detalhes de suas reservas</p>
            </div>

            <div class="max-w-7xl mx-auto space-y-4">

                @php
                    $hoje = \Carbon\Carbon::today();
                @endphp

                {{-- Reservas Futuras --}}
                <details class="group border rounded-lg shadow-sm bg-white open:shadow-md w-full">
                    <summary
                        class="cursor-pointer py-4 px-6 bg-light-gray text-primary-blue text-xl font-semibold hover:bg-beige-light">
                        Reservas Futuras
                    </summary>
                    <div class="grid grid-cols-1 gap-4 w-full">
                        @foreach ($bens as $bem)
                            @php
                                $inicio = \Carbon\Carbon::parse($bem->data_inicio);
                            @endphp
                            @if ($inicio->gt($hoje))
                                <x-card-reserva :bem="$bem" :caracteristicas="$caracteristicas" />
                            @endif
                        @endforeach
                    </div>
                </details>

                {{-- Reservas Atuais --}}
                <details class="group border rounded-lg shadow-sm bg-white open:shadow-md w-full">
                    <summary
                        class="cursor-pointer py-4 px-6 bg-light-gray text-orange-dark text-xl font-semibold hover:bg-beige-light">
                        Reservas a Decorrer
                    </summary>
                    <div class="grid grid-cols-1 gap-4 w-full">
                        @foreach ($bens as $bem)
                            @php
                                $inicio = \Carbon\Carbon::parse($bem->data_inicio);
                                $fim = \Carbon\Carbon::parse($bem->data_fim);
                            @endphp
                            @if ($inicio->lte($hoje) && $fim->gte($hoje))
                                <x-card-reserva :bem="$bem" :caracteristicas="$caracteristicas" status="decorrer" />
                            @endif
                        @endforeach
                    </div>
                </details>

                {{-- Reservas Passadas --}}
                <details class="group border rounded-lg shadow-sm bg-white open:shadow-md w-full">
                    <summary
                        class="cursor-pointer py-4 px-6 bg-gray-100 text-gray-700 text-xl font-semibold hover:bg-beige-light">
                        Reservas Passadas
                    </summary>
                    <div class="grid grid-cols-1 gap-4 w-full">
                        @foreach ($bens as $bem)
                            @php
                                $fim = \Carbon\Carbon::parse($bem->data_fim);
                            @endphp
                            @if ($fim->lt($hoje))
                                <x-card-reserva :bem="$bem" :caracteristicas="$caracteristicas" status="passada" />
                            @endif
                        @endforeach
                    </div>
                </details>

            </div>
        @endif
    </main>
</body>

</html>
