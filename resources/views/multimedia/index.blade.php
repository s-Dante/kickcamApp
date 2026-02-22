<x-general-layout title="Selecciona un País">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4">
        @foreach($countries as $country)
            <a href="{{ route('multimedia.watch', $country->slug) }}" class="border rounded-lg p-4 flex flex-col items-center hover:bg-gray-100 transition">
                <img src="{{ $country->flag_url }}" class="w-20 h-auto mb-2" alt="{{ $country->name }}">
                <span class="font-bold">{{ $country->name }}</span>
            </a>
        @endforeach
    </div>
</x-general-layout>