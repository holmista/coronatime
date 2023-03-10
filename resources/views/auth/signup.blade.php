<x-generic-layout>
    <div class="flex justify-between h-screen">
        <div class="mt-10 max-w-[430px] w-full flex justify-center lg:justify-end">
            <div class="w-11/12">
                <section>
                    <div class="flex">
                        <img src="/storage/logo.png" alt="">
                        <form method="post" action="/locale">
                            @csrf
                            <label for="language"></label>
                            <select name="language" id="language" class="border-0 outline-none"
                                onchange="this.form.submit()">
                                <option value="en" {{ App::isLocale('en') ? 'selected' : '' }}>
                                    {{ __('texts.english') }}
                                </option>
                                <option value="ka" {{ App::isLocale('ka') ? 'selected' : '' }}>
                                    {{ __('texts.georgian') }}
                                </option>
                            </select>
                        </form>
                    </div>
                    <h1 class="font-black text-[#010414] text-2xl mt-6 lg:mt-14">{{ __('texts.welcome_to_coronatime') }}
                    </h1>
                    <h3 class="text-lg text-[#808189]">{{ __('texts.please_enter_required_info_to_sign_up') }}</h3>
                </section>
                <form method="POST" action="/signup" class="mt-6">
                    @csrf
                    <div class="space-y-5">
                        <x-input-field name="username" type="text"
                            placeholder="{{ __('texts.enter_unique_username') }}"
                            moreInfo="{{ __('texts.username_should_be_unique_min_3_symbols') }}" />
                        <x-input-field name="email" type="email" placeholder="{{ __('texts.enter_your_email') }}" />
                        <x-input-field name="password" type="password"
                            placeholder="{{ __('texts.fill_in_password') }}" />
                        <x-input-field name="repeat_password" type="password"
                            placeholder="{{ __('texts.repeat_password') }}" />

                        <x-auth-button text="{{ __('texts.sign_up') }}" type="submit" />
                        <p class="text-[#808189] text-center lg:text-left">
                            {{ __('texts.already_have_an_account') }}
                            <a href="/signin" class="hover: cursor-pointer">
                                <strong class="text-[#010414]">{{ __('texts.log_in') }}</strong>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <img src="/storage/vaccine.png" alt="" class="hidden lg:block">
    </div>
</x-generic-layout>
