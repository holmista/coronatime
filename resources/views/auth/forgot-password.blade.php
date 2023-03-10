<x-generic-layout>
    <div class="">
        <section class="flex flex-col justify-center items-center w-screen mt-10">
            <div>
                <img src="/storage/logo.png" alt="">
            </div>
            <h1 class="font-black text-[#010414] text-2xl mt-14">{{ __('texts.reset_password') }}</h1>
        </section>
        <form method="POST" action="/forgot-password"
            class="w-screen h-screen absolute flex justify-center items-center top-0 ">
            @csrf
            <div class="space-y-5 max-w-[430px] w-full flex justify-center">
                <div class="w-11/12 flex flex-col justify-between lg:block">
                    <div>
                        <x-input-field name="email" type="email" placeholder="{{ __('texts.enter_your_email') }}" />
                    </div>
                    <div class="mt-6"></div>
                    <x-auth-button text="{{ strtoupper(__('texts.reset_password')) }}" type="submit" />
                </div>
            </div>
        </form>
    </div>
</x-generic-layout>
