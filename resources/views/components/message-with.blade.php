{{-- 
Este componente é utilizado para exibir mensagens de sucesso ou erro de forma estilizada, 
substituindo os tradicionais blocos:
        
        <div class="p-4 mb-4 text-white bg-green-500 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-white bg-red-500 rounded-md">
                {{ session('error') }}
            </div>
        @endif 
        
Este componente seria chamado:     
        @if (session('success'))
            <x-message-with type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-message-with type="error" :message="session('error')" />
        @endif
--}}

@props(['type' => 'success', 'message'])

@php
    $classes = [
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-500',
            'text' => 'text-green-700',
            'icon' => '<svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>',
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-500',
            'text' => 'text-red-700',
            'icon' => '<svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>',
        ],
    ];

    $style = $classes[$type] ?? $classes['success'];
@endphp

<div class="{{ $style['bg'] }} border-l-4 {{ $style['border'] }} p-4 mb-8 rounded-r-lg animate-fade-in-down"
    role="alert">
    <div class="flex items-center">
        <div class="flex-shrink-0">{!! $style['icon'] !!}</div>
        <div class="ml-3">
            <p class="text-sm {{ $style['text'] }}">{{ $message }}</p>
        </div>
    </div>
</div>
