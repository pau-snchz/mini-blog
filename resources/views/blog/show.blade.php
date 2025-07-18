<x-layout>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        {{-- Cafe Name --}}
        <h1 class="text-4xl font-bold mb-6 text-center">{{ $post->cafe_name }}</h1>

        {{-- Admin Edit/Delete Buttons --}}
        <div class="flex items-center justify-center">
            @auth
                @if(Auth::user()->user_type === 'admin')
                    <div class="flex gap-3 mb-6">
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

        {{-- Like Button --}}
        <div class="flex items-center justify-center mb-8">
            @auth
                @if(Auth::user()->user_type === 'subscriber')
                    <button onclick="toggleLike()"
                            class="flex items-center text-lg transition-all duration-200 hover:scale-105 transform cursor-pointer"
                            id="likeButton">
                        <svg class="w-6 h-6 mr-2 transition-all duration-200" viewBox="0 0 24 24" id="heartIcon">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="font-semibold" id="likeCount">{{ $post->like_count }}</span>
                        <span class="ml-1" id="likeText">{{ $post->like_count == 1 ? 'Like' : 'Likes' }}</span>
                    </button>
                @else
                    <div class="flex items-center text-red-500 text-lg">
                        <svg class="w-6 h-6 mr-2 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="font-semibold">{{ $post->like_count }} Likes</span>
                    </div>
                @endif
            @else
                <div class="flex items-center text-red-500 text-lg">
                    <svg class="w-6 h-6 mr-2 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="font-semibold">{{ $post->like_count }} Likes</span>
                </div>
            @endauth
        </div>

        {{-- Pictures Carousel --}}
        <div class="mb-8">
            @if($post->pictures->count())
                <div id="carousel" class="relative w-full">
                    <div class="relative h-96 overflow-hidden rounded-lg">
                        @foreach($post->pictures as $index => $picture)
                            <div class="carousel-item {{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out">
                                <img src="{{ asset($picture->picture_path) }}"
                                     class="absolute block w-full h-full object-cover"
                                     alt="Slide {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Previous/Next buttons --}}
                    @if($post->pictures->count() > 1)
                        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" onclick="previousSlide()">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" onclick="nextSlide()">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </button>
                    @endif

                    {{-- Indicators --}}
                    @if($post->pictures->count() > 1)
                        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
                            @foreach($post->pictures as $index => $picture)
                                <button type="button" class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" onclick="currentSlide({{ $index }})"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                    No Images Available
                </div>
            @endif
        </div>

        {{-- Blog Information --}}
        <div class="bg-white rounded-lg border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-8 mb-8">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                    <div class="space-y-3">
                        <p><span class="font-bold">Location:</span> {{ $post->location }}</p>
                        <p><span class="font-bold">Opening Hours:</span> {{ $post->opening_hours }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Blogger's Recommendations</h3>
                    <div class="space-y-3">
                        <p><span class="font-bold">Top Drink:</span> {{ $post->blogger_top_drink }}</p>
                        <p><span class="font-bold">Top Food:</span> {{ $post->blogger_top_food }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $post->description }}</p>
            </div>
        </div>

        {{-- Scores Section --}}
        <div class="bg-white rounded-lg border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-8 mb-8">
            <h3 class="text-lg font-semibold mb-4">Scores</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Affordability:</span>
                        <span class="font-bold">{{ $post->score_affordability }}/10</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ambiance:</span>
                        <span class="font-bold">{{ $post->score_ambiance }}/10</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Taste:</span>
                        <span class="font-bold">{{ $post->score_taste }}/10</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xl">Overall Score:</span>
                        <span class="font-bold text-xl text-[#ac764e]">{{ $post->score_overall }}/10</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Comments Section --}}
        <div class="bg-white rounded-lg border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-8">
            <h3 class="text-lg font-semibold mb-6" id="commentsHeader">Comments (<span id="commentCount">{{ $post->comments->count() }}</span>)</h3>

            {{-- Comment Form --}}
            @auth
                @if(Auth::user()->user_type === 'subscriber')
                    <form id="commentForm" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <textarea id="commentText" name="comment_text" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e]"
                                placeholder="Write your comment here..." required></textarea>
                            <div id="commentError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        <button type="submit" id="commentSubmitBtn"
                            class="bg-[#ac764e] text-white px-6 py-2 rounded-md hover:bg-[#965a42] transition">
                            Post Comment
                        </button>
                    </form>
                @else
                    <p class="mb-6 text-gray-600">Only subscribers can comment on posts.</p>
                @endif
            @else
                <p class="mb-6 text-gray-600">
                    <a href="{{ route('login') }}" class="text-[#ac764e] hover:underline">Login</a> to post a comment.
                </p>
            @endauth

            {{-- Display Comments --}}
            <div id="commentsContainer">
                @forelse($post->comments as $comment)
                    <div class="border-b border-gray-200 pb-4 mb-4 last:border-b-0 relative group">
                        <div class="flex items-start space-x-3">
                            {{-- Profile Picture --}}
                            @php
                                $profilePic = $comment->user->profile_picture
                                    ? asset('storage/' . $comment->user->profile_picture)
                                    : asset('images/default-pic.jpg');
                            @endphp
                            <img src="{{ $profilePic }}"
                                alt="{{ $comment->user->full_name }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-[#ac764e] flex-shrink-0">

                            {{-- Comment Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center mb-2">
                                    <span class="font-semibold text-[#ac764e] mr-2">{{ $comment->user->full_name }}</span>
                                    <span class="text-gray-500 text-sm">{{ $comment->created_at->format('M d, Y \a\t g:i A') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $comment->comment_text }}</p>
                            </div>
                        </div>

                        {{-- Delete option for comment owner OR admin --}}
                        @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->user_type === 'admin'))
                            <!-- More button (three dots) -->
                            <button type="button"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                                onclick="toggleDeleteBtn({{ $comment->id }})"
                                id="moreBtn-{{ $comment->id }}">
                                &#8230;
                            </button>
                            <!-- Delete button, initially hidden -->
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST"
                                id="deleteForm-{{ $comment->id }}"
                                class="hidden absolute top-10 right-3 z-10">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this comment?')"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center" id="noCommentsMessage">No comments yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Back Button --}}
        <div class="text-center mt-8">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
                ← Back to Blog Posts
            </a>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        // Carousel JavaScript
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.carousel-item');
        const indicators = document.querySelectorAll('[onclick^="currentSlide"]');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('hidden', i !== index);
            });

            if (indicators.length > 0) {
                indicators.forEach((indicator, i) => {
                    indicator.classList.toggle('bg-white', i === index);
                    indicator.classList.toggle('bg-white/50', i !== index);
                });
            }
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(currentSlideIndex);
        }

        function previousSlide() {
            currentSlideIndex = currentSlideIndex === 0 ? slides.length - 1 : currentSlideIndex - 1;
            showSlide(currentSlideIndex);
        }

        function currentSlide(index) {
            currentSlideIndex = index;
            showSlide(currentSlideIndex);
        }

        @auth
        function toggleDeleteBtn(commentId) {
            const deleteForm = document.getElementById('deleteForm-' + commentId);
            deleteForm.classList.toggle('hidden');
        }
        @endauth

        // Like functionality
        @auth
        @if(Auth::user()->user_type === 'subscriber')
        let isLiked = {{ $post->isLikedBy(Auth::id()) ? 'true' : 'false' }};

        function updateLikeButton(liked, count) {
            const heartIcon = document.getElementById('heartIcon');
            const likeButton = document.getElementById('likeButton');
            const likeCount = document.getElementById('likeCount');
            const likeText = document.getElementById('likeText');

            if (liked) {
                heartIcon.classList.remove('stroke-current', 'text-gray-500');
                heartIcon.classList.add('fill-current', 'text-red-500');
                likeButton.classList.remove('text-gray-500');
                likeButton.classList.add('text-red-500');
            } else {
                heartIcon.classList.remove('fill-current', 'text-red-500');
                heartIcon.classList.add('stroke-current', 'text-gray-500');
                likeButton.classList.remove('text-red-500');
                likeButton.classList.add('text-gray-500');
            }

            likeCount.textContent = count;
            likeText.textContent = count == 1 ? 'Like' : 'Likes';
        }

        updateLikeButton(isLiked, {{ $post->like_count }});

        async function toggleLike() {
            try {
                const response = await fetch('{{ route("blog.like", $post->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    isLiked = data.liked;
                    updateLikeButton(data.liked, data.like_count);
                } else {
                    alert(data.error || 'Something went wrong');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Network error. Please try again.');
            }
        }

        // Comment functionality
        document.getElementById('commentForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const commentText = document.getElementById('commentText');
            const submitBtn = document.getElementById('commentSubmitBtn');
            const errorDiv = document.getElementById('commentError');

            errorDiv.classList.add('hidden');
            errorDiv.textContent = '';

            if (!commentText.value.trim()) {
                errorDiv.textContent = 'Comment text is required.';
                errorDiv.classList.remove('hidden');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Posting...';

            try {
                const response = await fetch('{{ route("blog.comment", $post->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        comment_text: commentText.value.trim()
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    commentText.value = '';

                    document.getElementById('commentCount').textContent = data.comment_count;

                    const commentsContainer = document.getElementById('commentsContainer');
                    const noCommentsMessage = document.getElementById('noCommentsMessage');

                    if (noCommentsMessage) {
                        noCommentsMessage.remove();
                    }

                    const commentHtml = `
                        <div class="border-b border-gray-200 pb-4 mb-4 last:border-b-0 new-comment">
                            <div class="flex items-start space-x-3">
                                <img src="${data.comment.profile_picture}"
                                     alt="${data.comment.user_name}"
                                     class="w-10 h-10 rounded-full object-cover border-2 border-[#ac764e] flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center mb-2">
                                        <span class="font-semibold text-[#ac764e] mr-2">${data.comment.user_name}</span>
                                        <span class="text-gray-500 text-sm">${data.comment.created_at}</span>
                                    </div>
                                    <p class="text-gray-700">${data.comment.comment_text}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    commentsContainer.insertAdjacentHTML('afterbegin', commentHtml);

                    const newComment = commentsContainer.querySelector('.new-comment');
                    newComment.style.opacity = '0';
                    newComment.style.transform = 'translateY(-10px)';
                    newComment.style.transition = 'all 0.3s ease-out';

                    setTimeout(() => {
                        newComment.style.opacity = '1';
                        newComment.style.transform = 'translateY(0)';
                        newComment.classList.remove('new-comment');
                    }, 100);

                } else {
                    errorDiv.textContent = data.error || 'Failed to post comment';
                    errorDiv.classList.remove('hidden');
                }

            } catch (error) {
                console.error('Comment error:', error);
                errorDiv.textContent = 'Network error. Please try again.';
                errorDiv.classList.remove('hidden');
            }

            submitBtn.disabled = false;
            submitBtn.textContent = 'Post Comment';
        });
        @endif
        @endauth
    </script>
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