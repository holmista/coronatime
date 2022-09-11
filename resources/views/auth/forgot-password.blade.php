<x-generic-layout>
    <div class="">
        <section class="flex flex-col justify-center items-center w-screen mt-10">
            <div>
                <img src="/storage/logo.png" alt="">
            </div>
            <h1 class="font-black text-[#010414] text-2xl mt-14">Reset Password</h1>
        </section>
        <form method="POST" action="/signin" class="w-screen h-screen absolute flex justify-center items-center top-0 ">
            @csrf
            <div class="space-y-5 max-w-[392px] w-full">
                <div class="max-w-[392px] w-full">
                    <x-input-field name="email" type="email" placeholder="Enter your email" />
                </div>
                <div class="mt-6 "></div>
                <x-auth-button text="RESET PASSWORD" type="submit" />
            </div>
        </form>
    </div>
</x-generic-layout>
