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
                <div class="mb-20">
                    <p class="text-lg">
                        Your account is confirmed, you can sign in
                    </p>
                </div>
                <x-auth-button text="SIGN IN" link="/signin" />
            </div>
        </div>
    </div>
</x-generic-layout>
