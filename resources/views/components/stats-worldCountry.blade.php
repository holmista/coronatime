@props(['page'])

@if ($page === 'worldwide')
    <div class="text-[#010414] font-bold text-base flex gap-16 mt-5 border-b-2 border-[#F6F6F7]">
        <p class="py-5 border-b-4 border-[#010414]"><a href="/">Worldwide</a></p>
        <p class="py-5"><a href="/countries">By country</a></p>
    </div>
@else
    <div class="text-[#010414] font-bold text-base flex gap-16 mt-5 border-b-2 border-[#F6F6F7]">
        <p class="py-5"><a href="/">Worldwide</a></p>
        <p class="py-5 border-b-4 border-[#010414]"><a href="/countries">By country</a></p>
    </div>
@endif
