<x-generic-layout>
    <div class="">
        <section class="flex flex-col justify-center items-center w-screen mt-10">
            <div>
                <img src="/storage/logo.png" alt="">
            </div>
            <h1 class="font-black text-[#010414] text-2xl mt-14">Reset Password</h1>
        </section>
        <form method="POST" action="/reset-password"
            class="w-screen h-screen absolute flex justify-center items-center top-0 ">
            @csrf
            @method('patch')
            <div class="space-y-5 max-w-[392px] w-full">
                <input name="id" type="hidden" value="{{ request()->id }}">
                <input name="token" type="hidden" value="{{ request()->token }}">
                <x-input-field name="password" type="password" placeholder="Fill in password" />
                <x-input-field name="repeat_password" type="password" placeholder="Repeat password" />
                <x-auth-button text="SAVE CHANGES" type="submit" />
                @if ($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif
            </div>
        </form>
    </div>
</x-generic-layout>
