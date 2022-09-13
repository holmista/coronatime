<x-generic-layout>
    <div class="flex justify-between h-screen">
        <div class="mt-10 max-w-[430px] w-full flex justify-end">
            <div class="w-11/12">
                <section>
                    <img src="/storage/logo.png" alt="">
                    <h1 class="font-black text-[#010414] text-2xl mt-14">Welcome back</h1>
                    <h3 class="text-lg text-[#808189]">Welcome back! Please enter your details</h3>
                </section>
                <form method="POST" action="/signin" class="mt-6">
                    @csrf
                    <div class="space-y-5">
                        <x-input-field name="username" type="text" placeholder="Enter unique username or email" />
                        <x-input-field name="password" type="password" placeholder="Fill in password" />
                        <div class="mt-6 flex justify-between">
                            <div>
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember" class="text-[#010414] text-sm">Remember this device</label>
                            </div>
                            <a href="/forgot-password">
                                <p class="text-[#2029F3] text-sm">Forgot password?</p>
                            </a>
                        </div>
                        <x-auth-button text="SIGN IN" type="submit" />
                        <p class="text-[#808189] ">
                            Don't have and account?
                            <a href="/signup" class="hover: cursor-pointer">
                                <strong class="text-[#010414]">Sign up for free</strong>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <img src="/storage/vaccine.png" alt="">
    </div>
</x-generic-layout>
