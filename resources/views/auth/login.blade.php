<x-layout>
    <div class="max-w-md mx-auto bg-white rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-8 mt-8">
        <div class="flex flex-col items-center justify-center gap-2 text-[#ac764e]">
            <i class="fa-solid fa-mug-hot fa-2x"></i>
            <h2 class="text-2xl font-bold">Login</h2>
        </div>

        @if(session('status'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
                <ul class="pl-4 list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block font-semibold mb-2">Email Address</label>
                <input type="email" name="email" id="email" required autofocus
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#ac764e]">
            </div>

            <div>
                <label for="password" class="block font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#ac764e]">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-[#ac764e] text-white px-4 py-2 rounded hover:bg-[#8b5c36] transition">Login</button>
                <a href="{{ route('register') }}" class="text-[#ac764e] hover:underline">Don't have an account?</a>
            </div>
        </form>
    </div>
</x-layout>