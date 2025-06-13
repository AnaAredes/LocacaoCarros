<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multibanco</title>
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

<body class="bg-gray-50">
    @include('layouts.navigation')
    <section class="pt-[50px] relative">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-bold text-primary-blue mb-4">Pagamento via Referência Multibanco</h2>

                <p class="text-gray-700 mb-2"><strong>Entidade:</strong> {{ $entidade }}</p>
                <p class="text-gray-700 mb-2"><strong>Nome da Entidade:</strong> {{ $nome_entidade }}</p>
                <p class="text-gray-700 mb-2"><strong>Referência:</strong> {{ $referencia }}</p>
                <p class="text-gray-700 mb-4"><strong>Valor:</strong> {{ number_format($valor, 2, ',', '.') }} €</p>

                <p class="text-green-600 font-semibold mt-4">Esta referência é válida por 24 horas.</p>
                
                <form method="GET" action="{{ route('pagamento.sucesso', ['tipo' => 'multibanco']) }}" class="mt-6">
                    @csrf
                    {{-- Se quiser passar algum identificador, pode adicionar como hidden input --}}
                    <input type="hidden" name="referencia" value="{{ $referencia }}">
                    <input type="hidden" name="valor" value="{{ $valor }}">

                    <button type="submit"
                        class="w-full bg-primary-blue text-white px-6 py-2 rounded-lg hover:bg-orange-light transition focus:outline-none focus:ring-2 focus:ring-orange-light focus:ring-offset-2">
                        Confirmar Pagamento Realizado
                    </button>
                </form>
            </div>
        </main>
    </section>
</body>
