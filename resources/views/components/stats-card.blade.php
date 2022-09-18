@props(['image', 'text', 'number', 'numberColor'])

<div
    {{ $attributes->merge(['class' => 'max-w-[392px] max-h-[255px] flex flex-col justify-around items-center py-5 sm:py-8 rounded-2xl shadow-md']) }}>
    <div>
        <img src="/storage/{{ $image }}" alt="">
    </div>
    <div>
        <p class="text-xl text-[#010414] py-">{{ __('texts.' . $text) }}</p>
    </div>
    <div>
        @switch($numberColor)
            @case('green')
                <p class="text-[#0FBA68] text-4xl font-black">{{ $number }}</p>
            @break

            @case('purple')
                <p class="text-[#2029F3] text-4xl font-black">{{ $number }}</p>
            @break

            @case('yellow')
                <p class="text-[#EAD621] text-4xl font-black">{{ $number }}</p>
            @break

            @default
                <p class="text-black text-4xl font-black">{{ $number }}</p>
        @endswitch
    </div>
</div>
