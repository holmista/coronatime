<div class="py-4 border-2 border-[#E6E6E7] flex items-center max-w-[240px] rounded-lg h-12 mt-8">
    <div class="pl-6 pr-4">
        <img src="/storage/magnifier.png" alt="">
    </div>
    <form method="GET" action="/countries#">
        <input placeholder="Search by country" type="text" name="search"
            class="max-w-[165px] w-full outline-none text-[#808189] text-md border-solid border-2 border-white"
            value="{{ request('search') }}">
    </form>
</div>
