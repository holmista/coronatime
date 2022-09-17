<x-generic-layout>
    <div class="flex flex-col items-center h-screen">
        <div class="mt-10">
            <img src="/storage/logo.png" alt="">
        </div>
        <div class="absolute flex justify-center items-center h-screen w-screen">
            <div class="flex flex-col justify-center items-center">
                <div>
                    <img src="/storage/tick.png" alt="">
                </div>

                <p class="text-lg">
                    {{ __('texts.we_have_sent_you_a_confirmation_email') }}
                </p>
            </div>
        </div>
    </div>
</x-generic-layout>
