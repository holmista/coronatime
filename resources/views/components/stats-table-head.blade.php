@props(['name'])

<th scope="col" class="px-1 sm:px-3 py-3.5 text-left text-sm font-semibold text-[#010414]">
    <div class="flex items-center colName">
        <div>
            {{ $name }}
        </div>
        <div class="pl-2 flex flex-col justify-between h-[14px]">
            <x-stats-arrowUp />
            <x-stats-arrowDown />
        </div>
    </div>
</th>
