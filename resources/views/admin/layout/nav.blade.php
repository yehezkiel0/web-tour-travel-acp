<div class="navbar-bg">
    <nav class="absolute left-[250px] right-[5px] flex py-2 items-center justify-between z-[890] h-[70px] transition-all ease-in-out duration-700"
        id="navbar-admin">
        <div class="px-4">
            <ul>
                <li>
                    <a href="#" class="text-white text-lg" id="toggle-sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <ul class="flex flex-row w-full justify-end items-center">
            <li class="px-4">
                <a href="#"
                    class="bg-yellow-400 hover:bg-yellow-300 shadow-yellow-200 shadow-sm text-white px-3 py-1 rounded">
                    Front-end
                </a>
            </li>
            <li class="relative px-4">
                <a href="#" class="text-white text-xl flex flex-row gap-x-3 items-center" data-dropdown="admin">
                    <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}" alt=""
                        class="w-[40px] h-[40px] rounded-full">
                    <i class="fa-solid fa-caret-down text-xs text-slate-200"></i>
                </a>
                <ul class="bg-white shadow-lg w-48 absolute top-[50px] right-0 rounded-md py-4 px-6 z-[1000] hidden"
                    id="dropdown-profile">
                    <li class="py-2 z-[1000]">
                        <a class="text-sm flex items-center gap-x-3 text-slate-500"
                            href="{{ route('admin_profile') }}"><i class="far fa-user"></i>Edit
                            Profile</a>
                    </li>
                    <li class="py-2 z-[1000]">
                        <a class="text-sm flex items-center gap-x-3 text-slate-500"
                            href="{{ route('admin_logout') }}"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>
</div>
