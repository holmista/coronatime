@props(['text', 'type' => '', 'link' => '#'])

@if ($type === 'submit')
    <button type="{{ $type }}" class="max-w-[392px] w-full bg-[#0FBA68] rounded-lg">
        <p class="py-4 text-center text-sm font-black text-white">
            {{ $text }}
        </p>
    </button>
@else
    <button type="{{ $type }}" class="max-w-[392px] w-full bg-[#0FBA68] rounded-lg">
        <a href="{{ $link }}">
            <p class="py-4 text-center text-sm font-black text-white">
                {{ $text }}
            </p>
        </a>
    </button>
@endif
