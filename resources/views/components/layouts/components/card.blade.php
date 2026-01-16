@props(['title', 'image' => null, 'link' => '#'])

<div class="bg-white rounded shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    @if($image)
        <a href="{{ $link }}" class="block">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
        </a>
    @endif

    <div class="p-5">
        <a href="{{ $link }}" class="block">
            <h3 class="text-xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                {{ $title }}
            </h3>
        </a>

        <div>
            {{ $slot }}
        </div>
    </div>
</div>
