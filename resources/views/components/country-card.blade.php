@props(['href', 'country'])

<a href="{{ $href }}"
    class="group block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-200">
    <div class="aspect-w-16 aspect-h-9 w-full bg-gray-100 flex items-center justify-center relative overflow-hidden">
        @if($country->flag_url)
            <img src="{{ Str::startsWith($country->flag_url, 'http') ? $country->flag_url : asset('storage/' . $country->flag_url) }}"
                alt="{{ $country->name }} flag"
                class="w-full h-full object-cover filter brightness-[0.9] group-hover:scale-110 transition-transform duration-300">
        @else
            <span class="text-6xl filter drop-shadow-md group-hover:scale-110 transition-transform duration-300">🏳️</span>
        @endif
    </div>
    <div class="p-4 border-t border-gray-50">
        <h4 class="font-bold text-gray-900 text-lg mb-1 group-hover:text-indigo-600 transition-colors">
            {{ $country->name }}
        </h4>
        <div class="flex items-center text-xs text-gray-500 font-medium mt-2">
            {{ $slot }}
        </div>
    </div>
</a>