@props(['name', 'slug'])
{{-- @dd('/countries/{{ Arr::query(array_merge(Request::except($slug), [$slug => 'asc'])) }}') --}}
<th scope="col" class="px-1 sm:px-3 py-3.5 text-left text-sm font-semibold text-[#010414]">
    <div class="flex items-center colName">
        <div>
            {{ $name }}
        </div>
        <div class="pl-2 flex flex-col justify-between h-[14px]">
            <a href="/countries?{{ Arr::query(array_merge(Request::except($slug), [$slug => 'asc'])) }}">
                <x-stats-arrowUp name="asc-{{ $slug }}" />
            </a>
            <a href="/countries?{{ Arr::query(array_merge(Request::except($slug), [$slug => 'desc'])) }}">
                <x-stats-arrowDown name="desc-{{ $slug }}" />
            </a>
        </div>
    </div>
</th>
