<nav class="py-8 w-screen flex justify-center border-b-2 border-[#F6F6F7]">
    <div class="w-11/12 flex justify-between">
        <div class="flex flex-shrink-0">
            <img src="/storage/logo.png" alt="" class="w-10/12 sm:w-full">
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3">
            <div>
                <label for="language"></label>
                <select name="language" id="language" class="border-0 outline-none">
                    <option value="English">English</option>
                    <option value="Georgian">Georgian</option>
                </select>
            </div>
            <div class="hidden justify-center items-center sm:flex">
                <p>Takeshi.K</p>
            </div>
            <div class="hidden justify-center items-center border-l-2 border-[#F6F6F7] sm:flex">
                <form action="/signout">
                    @csrf
                    <button type="submit">
                        Log Out
                    </button>
                </form>
            </div>
            <div class="flex justify-end items-center sm:hidden" id="hamburger">
                <img src="/storage/burgerMenu.png" alt="" class="hover:cursor-pointer">
                <div class="hidden absolute mt-20" id="littleMenu">
                    <div>
                        <div class="justify-center items-center sm:flex">
                            <p>Takeshi.K</p>
                        </div>
                        <div class="justify-center items-center border-l-2 border-[#F6F6F7] sm:flex">
                            <form action="/signout">
                                @csrf
                                <button type="submit">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</nav>