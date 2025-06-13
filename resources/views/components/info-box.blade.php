@props(['data', 'text'])

<div class="p-3 bg-white rounded-lg shadow flex items-center gap-2">
    {{ $slot }}
    <p class="font-medium text-gray-700">{{ ucfirst($data) }} {{ $text }}</p>
</div>
