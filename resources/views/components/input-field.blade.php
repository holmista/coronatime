@props(['name', 'type', 'placeholder', 'moreInfo' => ''])

<div>
    <label for="{{ $name }}">
        <p class="text-[#010414] text-sm">
            {{ ucfirst(str_replace('_', ' ', $name)) }}
        </p>
    </label>
    <div class="mt-2">
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}",
            placeholder="{{ $placeholder }}"
            class="max-w-[392px] w-full py-4 pl-6 outline-none text-[#808189] text-sm border-solid border-2 border-[#E6E6E7] rounded-lg">
    </div>
    <div class="mt-1">
        <p class="text-[#808189] text-xs">{{ $moreInfo }}</p>
    </div>
</div>
