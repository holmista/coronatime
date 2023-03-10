<x-generic-layout>
    <x-stats-navbar />
    <div class="w-full flex justify-center">
        <div class="w-11/12">
            <h1 class="text-2xl text-[#010414] font-extrabold mt-7 sm:mt-10">
                {{ __('texts.worldwide_statistics') }}
            </h1>
            <x-stats-worldCountry page="worldwide" />
            <x-stats-cards :worldwide="$data" />
        </div>
    </div>
</x-generic-layout>
