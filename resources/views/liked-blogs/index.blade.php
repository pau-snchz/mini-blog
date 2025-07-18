<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">My Liked Blogs</h1>
            <p class="text-gray-600">Your favorite cafe reviews</p>
        </div>

        @if($likedPosts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="likedBlogsContainer">
                @foreach($likedPosts as $post)
                    <div class="bg-white rounded-lg border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] overflow-hidden transition-transform hover:scale-105"
                         id="blog-card-{{ $post->id }}">

                        {{-- Blog Image --}}
                        <div class="relative h-48 overflow-hidden">
                            @if($post->pictures->count() > 0)
                                <img src="{{ asset($post->pictures->first()->picture_path) }}"
                                     alt="{{ $post->cafe_name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif

                            {{-- Like Count Overlay --}}
                            <div class="absolute top-3 right-3 bg-black/70 text-white px-2 py-1 rounded-full flex items-center">
                                <svg class="w-4 h-4 fill-current text-red-500 mr-1" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span class="text-sm">{{ $post->like_count }}</span>
                            </div>
                        </div>

                        {{-- Blog Content --}}
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $post->cafe_name }}</h3>

                            <div class="text-sm text-gray-600 mb-3">
                                <p class="flex items-center mb-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $post->location }}
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $post->opening_hours }}
                                </p>
                            </div>

                            <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ Str::limit($post->description, 120) }}</p>

                            {{-- Scores --}}
                            <div class="grid grid-cols-2 gap-2 text-xs mb-4">
                                <div class="flex justify-between">
                                    <span>Affordability:</span>
                                    <span class="font-bold">{{ $post->score_affordability }}/10</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Ambiance:</span>
                                    <span class="font-bold">{{ $post->score_ambiance }}/10</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Taste:</span>
                                    <span class="font-bold">{{ $post->score_taste }}/10</span>
                                </div>
                                <div class="flex justify-between font-bold text-[#ac764e]">
                                    <span>Overall:</span>
                                    <span>{{ $post->score_overall }}/10</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex justify-between items-center space-x-3">
                                <a href="{{ route('blog.show', $post->id) }}"
                                   class="flex-1 bg-[#ac764e] text-white text-center py-2 px-4 rounded-md hover:bg-[#965a42] transition text-sm">
                                    Read More
                                </a>

                                <button onclick="removeLike({{ $post->id }})"
                                        class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition text-sm flex items-center"
                                        id="remove-btn-{{ $post->id }}">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <div class="bg-white rounded-lg border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-12 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Liked Blogs Yet</h3>
                    <p class="text-gray-600 mb-6">Start exploring and liking your favorite cafe reviews!</p>
                    <a href="{{ route('home') }}"
                       class="inline-block bg-[#ac764e] text-white px-6 py-3 rounded-md hover:bg-[#965a42] transition">
                        Browse Blogs
                    </a>
                </div>
            </div>
        @endif

        {{-- Back to Home Button --}}
        <div class="text-center mt-8">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
                ← Back to All Blogs
            </a>
        </div>
    </div>

    {{-- JavaScript for Real-time Removal --}}
    <script>
        async function removeLike(postId) {
            const button = document.getElementById(`remove-btn-${postId}`);
            const card = document.getElementById(`blog-card-${postId}`);

            button.disabled = true;
            button.innerHTML = `
                <svg class="w-4 h-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Removing...
            `;

            try {
                const response = await fetch(`/liked-blogs/${postId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0.5';
                    card.style.transition = 'all 0.3s ease-out';

                    setTimeout(() => {
                        card.remove();

                        const remainingCards = document.querySelectorAll('[id^="blog-card-"]');
                        if (remainingCards.length === 0) {
                            location.reload();
                        }
                    }, 300);

                } else {
                    alert(data.error || 'Failed to remove blog from liked list');

                    button.disabled = false;
                    button.innerHTML = `
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Remove
                    `;
                }

            } catch (error) {
                console.error('Error removing like:', error);
                alert('Network error. Please try again.');

                button.disabled = false;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Remove
                `;
            }
        }
    </script>
</x-layout>