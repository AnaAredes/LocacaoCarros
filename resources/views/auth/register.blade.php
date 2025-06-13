<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Página de Registo</title>
  <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])    
</head>

<body class="relative min-h-screen flex items-center justify-center">

    <!-- Background image with gradient overlay -->
   <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1689757335928-9ae74832fab7?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
             alt="Background"
             class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-b from-primary-blue to-dark-gray opacity-80"></div>
    </div>

    <!-- Form Container -->
    <div class="relative z-10 w-full max-w-md bg-gray-50 p-8 rounded-lg shadow-lg">
         <div class="flex items-center justify-center">
            <x-application-logo class="w-9 h-9" />
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input id="name" name="name" type="text" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-purple-light focus:border-purple-light sm:text-sm">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-purple-light focus:border-purple-light sm:text-sm">
            </div>

            <!-- NIF -->
            <div>
                <label for="nif" class="block text-sm font-medium text-gray-700">NIF</label>
                <input id="nif" name="nif" type="text" pattern="\d{9}" maxlength="9" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-purple-light focus:border-purple-light sm:text-sm">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-purple-light focus:border-purple-light sm:text-sm">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-purple-light focus:border-purple-light sm:text-sm">
            </div>

            <!-- Login Link -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm font-medium text-purple-dark hover:text-purple-light">
                    Já está registado?
                </a>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-dark hover:bg-purple-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-light">
                    Registar
                </button>
            </div>
        </form>
    </div>

</body>
</html>
