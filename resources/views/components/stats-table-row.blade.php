@props(['location', 'newCases', 'deaths', 'recovered'])

<tr class="text-[#010414] text-sm">
    <td class="py-4 pl-4 ">{{ $location }}</td>
    <td class="whitespace-nowrap px-3 py-4 ">{{ $newCases }}</td>
    <td class="whitespace-nowrap px-3 py-4 ">{{ $deaths }}</td>
    <td class="whitespace-nowrap px-3 py-4 ">{{ $recovered }}</td>
</tr>
