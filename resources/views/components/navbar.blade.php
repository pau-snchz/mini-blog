<div class="bg-[url(images/banner-bg.jpg)] text-white">
    <div class="bg-black/50">
        <img src="images/mug&munch-logo.png" alt="mug&munch Logo Icon" class="w-[300px] py-10 m-auto">
    </div>
    <div class="bg-[#ac764e] flex justify-around items-center py-3">
        <ul class="flex space-x-10">
            <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
            <li><a href="" class="hover:underline">Liked Blogs</a></li>
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
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-danger bg-red-600 hover:bg-red-700 px-2 py-1 rounded">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary hover:underline">Login</a>
            @endauth
        </div>
    </div>
</div>
