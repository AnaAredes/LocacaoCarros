<header class="fixed w-full bg-white/90 backdrop-blur-sm z-50 shadow-sm">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-2 text-2xl font-bold text-gray-800">
            <x-application-logo class="w-9 h-9" />
            <a href="{{ url('/') }}">Rota Certa</a>
        </div>
        <div class="hidden md:flex space-x-8">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition duration-300">Início</a>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 transition duration-300">
                        {{ Auth::user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 transition duration-300">
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition duration-300">
                        Entrar
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 transition duration-300">
                            Registar
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>
</header>
