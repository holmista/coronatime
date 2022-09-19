@props(['data'])

<div class="">
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50 {{ App::isLocale('ka') ? 'break-all' : '' }}">
                            <tr>
                                <x-stats-table-head name="Location" slug="country" />
                                <x-stats-table-head name="New cases" slug="confirmed" />
                                <x-stats-table-head name="Deaths" slug="deaths" />
                                <x-stats-table-head name="Recovered" slug="recovered" />
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($data as $country)
                                <x-stats-table-row location="{{ $country->country }}"
                                    newCases="{{ $country->confirmed }}" deaths="{{ $country->deaths }}"
                                    recovered="{{ $country->recovered }}" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
