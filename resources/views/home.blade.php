<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col justify-between items-center gap-5 mb-8">
            <h1 class="text-3xl font-bold text-center flex-1">Blog Posts</h1>

            {{-- Blog Button for Admins --}}
            @auth
                @if(Auth::user()->user_type === 'admin')
                    <a href="{{ route('blog.create') }}"
                       class="text-white text-sm px-6 py-2 rounded-lg bg-[#63372c] hover:bg-[#734b41] transition-colors font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Blog
                    </a>
                @endif
            @endauth
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <div class="bg-white rounded-xl border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] overflow-hidden flex flex-col">
                    {{-- Blog Post Picture --}}
                    @if($post->pictures->count())
                        <img src="{{ asset($post->pictures->first()->picture_path) }}"
                             alt="{{ $post->cafe_name }} main image"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    <div class="p-6 flex flex-col flex-1">
                        <h2 class="text-xl font-semibold mb-2">{{ $post->cafe_name }}</h2>
                        <p class="text-gray-700 text-sm mb-1">
                            <span class="font-bold text-[#ac764e]">Location:</span> {{ $post->location }}
                        </p>
                        <p class="text-gray-700 text-sm mb-1">
                            <span class="font-bold text-[#ac764e]">Opening Hours:</span> {{ $post->opening_hours }}
                        </p>
                        <p class="text-gray-700 mb-4 text-sm">
                            {{ Str::limit($post->description, 90) }}
                        </p>

                        {{-- Like Count with Heart Icon --}}
                        <div class="flex items-center mb-4 text-red-500">
                            <svg class="w-5 h-5 mr-1 fill-current" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="text-sm">{{ $post->like_count }}</span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-auto space-y-2">
                            {{-- Read More Button --}}
                            <a href="{{ route('blog.show', $post->id) }}"
                               class="block bg-[#ac764e] text-white rounded px-4 py-2 transition hover:bg-[#8b5c36] text-center">
                                Read More
                            </a>

                            {{-- Admin Edit/Delete Buttons --}}
                            @auth
                                @if(Auth::user()->user_type === 'admin')
                                    <div class="flex space-x-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('blog.edit', $post->id) }}"
                                           class="flex-1 bg-blue-600 text-white rounded px-3 py-2 transition hover:bg-blue-700 text-center text-sm font-semibold flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>

                                        {{-- Delete Button --}}
                                        <button onclick="confirmDelete({{ $post->id }})"
                                                class="flex-1 bg-red-600 text-white rounded px-3 py-2 transition hover:bg-red-700 text-center text-sm font-semibold flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>

                                    {{-- Hidden Delete Form --}}
                                    <form id="delete-form-{{ $post->id }}" action="{{ route('blog.destroy', $post->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- JavaScript for Delete Confirmation --}}
    @auth
        @if(Auth::user()->user_type === 'admin')
            <script>
                function confirmDelete(postId) {
                    if (confirm('Are you sure you want to delete this blog post? This action cannot be undone.')) {
                        document.getElementById('delete-form-' + postId).submit();
                    }
                }
            </script>
        @endif
    @endauth
</x-layout>