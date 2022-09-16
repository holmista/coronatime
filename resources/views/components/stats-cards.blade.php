@props(['worldwide'])

<div class="grid grid-cols-2 gap-6 mt-6 sm:grid-cols-3 sm:mt-10">
    <x-stats-card image="purpleGraph.png" text="New cases" number="{{ $worldwide->confirmed }}" numberColor="purple"
        class="bg-[#ececfc] col-span-2 sm:col-span-1 sm:max-h-48" />
    <x-stats-card image="greenGraph.png" text="Recovered" number="{{ $worldwide->recovered }}" numberColor="green"
        class="bg-[#eaf8f1] " />
    <x-stats-card image="yellowGraph.png" text="Death" number="{{ $worldwide->deaths }}" numberColor="yellow"
        class="bg-[#fcfaec] " />
</div>
