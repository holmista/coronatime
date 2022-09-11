<x-generic-layout>
    <div class="flex justify-between h-screen">
        <div class="mt-10 max-w-[430px] w-full flex justify-end">
            <div class="w-11/12">
                <section>
                    <img src="/storage/logo.png" alt="">
                    <h1 class="font-black text-[#010414] text-2xl mt-14">Welcome to Coronatime</h1>
                    <h3 class="text-lg text-[#808189]">Please enter required info to sign up</h3>
                </section>
                <form method="POST" action="/signup" class="mt-6">
                    @csrf
                    <div class="space-y-5">
                        <x-input-field name="username" type="text" placeholder="Enter unique username"
                            moreInfo="Username should be unique, min 3 symbols" />
                        <x-input-field name="email" type="email" placeholder="Enter your email" />
                        <x-input-field name="password" type="password" placeholder="Fill in password" />
                        <x-input-field name="repeat_password" type="password" placeholder="Repeat password" />

                        <x-auth-button text="SIGN UP" type="submit" />
                        <p class="text-[#808189] ">
                            Already have an account?
                            <a href="/signin" class="hover: cursor-pointer">
                                <strong class="text-[#010414]">Log in</strong>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <img src="/storage/vaccine.png" alt="">
    </div>
</x-generic-layout>
