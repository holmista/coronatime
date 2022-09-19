{{-- @props(['data']) --}}
{{-- @dd($data[0]) --}}
<x-generic-layout>
    <div class="overflow-x-hidden overflow-y-hidden">
        <x-stats-navbar />
        <div class="w-full flex justify-center">
            <div class="w-11/12">
                <h1 class="text-2xl text-[#010414] font-extrabold mt-7 sm:mt-10">
                    {{ __('texts.worldwide_statistics') }}
                </h1>
                <x-stats-worldCountry page="byCountry" />
                <x-stats-searchbar />
                <x-stats-table :data="$data" />
            </div>
        </div>
    </div>
</x-generic-layout>
