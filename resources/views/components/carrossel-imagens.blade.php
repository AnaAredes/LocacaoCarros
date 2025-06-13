@props(['imageUrl', 'modelo', 'altura_miniaturas' ])


<div>
    <!-- Imagem Principal -->
    <div class="rounded-lg overflow-hidden mb-6 shadow-lg">
        <img id="mainImage"
            src="{{ $imageUrl ?? 'https://images.unsplash.com/photo-1525609002-ab340263897e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
            alt="{{ $modelo }}"
            class="w-full h-80 md:h-96 object-cover transform transition duration-300 ease-in-out hover:scale-105 cursor-zoom-in">
    </div>
    <!-- Miniaturas -->
    <div class="grid grid-cols-4 gap-4">
        {{-- Certifique-se que $bem->fotos é uma coleção ou array de URLs --}}
        @php
            $array_imagens = [
                'https://images.unsplash.com/photo-1667893530449-e58102223524?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1591388156010-dd522151da35?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1629280878139-038999084e23?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ];

            // Adiciona a imagem principal ao array de miniaturas se estiver disponível
            if ($imageUrl) {
                array_unshift($array_imagens, $imageUrl);
            } else {
                array_unshift(
                    $array_imagens,
                    'https://images.unsplash.com/photo-1525609002-ab340263897e?q=80&w=2070&auto=format&fit=crop',
                );
            }
        @endphp


        @foreach (array_slice($array_imagens, 0, 4) as $key => $fotoUrl)
            <img src="{{ $fotoUrl }}" alt="Foto {{ $key + 1 }} de {{ $modelo }}"
                class="w-full {{ $altura_miniaturas }}  object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-primary-blue transition duration-300"
                onclick="document.getElementById('mainImage').src = this.src;">
        @endforeach
    </div>
</div>
