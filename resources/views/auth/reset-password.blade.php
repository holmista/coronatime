<x-generic-layout>
    <div class="flex flex-col items-center h-screen">
        <div class="mt-10">
            <img src="/storage/logo.png" alt="">
        </div>
        <div class="absolute flex justify-center items-center h-screen w-screen">
            <h1 class="font-black text-2xl">
                Reset Password
            </h1>
            <form method="POST" action="/reset-password" class="flex flex-col justify-center items-center">
                <x-input-field name="email" type="email" placeholder="Enter your email" />
                <x-auth-button text="RESET PASSWORD" type="submit" />
            </form>
        </div>
    </div>
</x-generic-layout>
