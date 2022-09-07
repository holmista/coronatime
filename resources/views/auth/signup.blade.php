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
                        <x-input-field name="Username" type="text" placeholder="Enter unique username"
                            moreInfo="Username should be unique, min 3 symbols" />
                        <x-input-field name="Email" type="email" placeholder="Enter your email" />
                        <x-input-field name="Password" type="password" placeholder="Fill in password" />
                        <x-input-field name="Repeat password" type="password" placeholder="Repeat password" />
                        <div class="mt-6">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" class="text-[#010414] text-sm">Remember this device</label>
                        </div>
                        <x-auth-button text="Sign Up" />
                        <p class="text-[#808189] ">
                            Already have an account?
                            <a href="/login" class="hover: cursor-pointer">
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
