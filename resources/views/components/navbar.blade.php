<div class="bg-cover bg-center text-white" style="background-image: url('{{ asset('images/banner-bg.jpg') }}');">
    <div class="bg-black/50">
        <img src="{{ asset('images/mug&munch-logo.png') }}" alt="mug&munch Logo Icon" class="w-[300px] py-10 m-auto">
    </div>
    <div class="bg-[#ac764e] flex justify-around items-center py-3">
        <ul class="flex space-x-10 items-center">
            <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
            @auth
                @if(Auth::user()->user_type === 'admin')
                <li class="relative group">
                    <a href="#" class="hover:underline flex items-center">
                        Admin
                        <svg class="ml-1 w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    <ul class="absolute left-0 top-full w-40 bg-[#ac764e] border border-[#8d6138] rounded shadow-lg opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-200 z-10">
                        <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-[#a47a54]">Dashboard</a></li>
                        <li><a href="{{--{{ route('admin.users') }}--}}" class="block px-4 py-2 hover:bg-[#a47a54]">Users</a></li>
                        <li><a href="{{--{{ route('admin.comments') }}--}}" class="block px-4 py-2 hover:bg-[#a47a54]">Comments</a></li>
                    </ul>
                </li>
                @elseif(Auth::user()->user_type === 'subscriber')
                    <li><a href="{{ route('liked.blogs') }}" class="hover:underline">Liked Blogs</a></li>
                @endif
            @endauth
        </ul>
        <div>
            @auth
                <div class="flex items-center space-x-4">
                    @php
                        $profilePic = Auth::user()->profile_picture
                            ? asset('storage/' . Auth::user()->profile_picture)
                            : asset('images/default-pic.jpg');
                    @endphp
                    <img src="{{ $profilePic }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-white">
                    <span class="text-white font-medium">{{ Auth::user()->username }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-danger bg-[#63372c] hover:bg-[#734b41] px-2 py-1 rounded">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary hover:underline">Login</a>
            @endauth
        </div>
    </div>
</div>