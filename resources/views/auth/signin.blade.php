<x-generic-layout>
    <div class="flex justify-between h-screen">
        <div class="mt-10 max-w-[430px] w-full flex justify-end">
            <div class="w-11/12">
                <section>
                    <img src="/storage/logo.png" alt="">
                    <h1 class="font-black text-[#010414] text-2xl mt-14">{{ __('texts.welcome_back') }}</h1>
                    <h3 class="text-lg text-[#808189]">{{ __('texts.welcome_back_please_enter_your_details') }}</h3>
                </section>
                <form method="POST" action="/signin" class="mt-6">
                    @csrf
                    <div class="space-y-5">
                        <x-input-field name="username" type="text"
                            placeholder="{{ __('texts.enter_unique_username_or_email') }}" />
                        <x-input-field name="password" type="password"
                            placeholder="{{ __('texts.fill_in_password') }}" />
                        <div class="mt-6 flex justify-between">
                            <div class="relative flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="remember" name="remember" type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-[#249E2C] focus:ring-white">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember"
                                        class="font-bold text-sm text-[#010414]">{{ __('texts.remember_this_device') }}</label>
                                </div>
                            </div>
                            <a href="/forgot-password">
                                <p class="text-[#2029F3] text-sm">{{ __('texts.forgot_password') }}</p>
                            </a>
                        </div>
                        <x-auth-button text="{{ __('texts.sign_in') }}" type="submit" />
                        <p class="text-[#808189] ">
                            {{ __('texts.dont_have_an_account') }}
                            <a href="/signup" class="hover: cursor-pointer">
                                <strong class="text-[#010414]">{{ __('texts.sign_up_for_free') }}</strong>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <img src="/storage/vaccine.png" alt="">
    </div>
</x-generic-layout>
