<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rota Certa') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
  <body class="font-['Open Sans'] bg-white">

    <!-- Header fixo -->
    <header class="fixed w-full bg-white/90 backdrop-blur-sm z-50 shadow-sm">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-['Montserrat'] font-bold text-gray-800">Rota Certa</div>
            <div class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-600 hover:text-gray-900 transition duration-300">Início</a>
               @yield('body_content')
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="pt-[70px] relative h-[45vh]">
        <img src="https://images.unsplash.com/photo-1523365154888-8a758819b722" alt="Natureza Portuguesa" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
            <div class="text-center text-white px-4 flex flex-col items-center">
                <h1 class="text-3xl md:text-5xl font-bold mt-6">
                    Alugue com facilidade, conduza com liberdade
                </h1>
                <div class="flex justify-center w-full">
                    <a href="/disponiveis">
                        <button class="bg-white text-gray-900 px-12 py-4 rounded-full font-semibold hover:bg-purple-light transition duration-300 flex items-center justify-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <span>Pesquisar</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Conteúdo adicional da página -->
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{-- Usa $slot para páginas com layout component --}}
            {{ $slot ?? '' }}

            {{-- Usa yield para páginas com section content --}}
            @yield('body_content')
        </main>
    </div>

</body>
</html>