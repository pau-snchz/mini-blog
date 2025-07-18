<x-layout>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg border-2 border-[#ac764e] shadow-[4px_4px_0px_#ac764e] p-8">
            <h1 class="text-3xl font-bold mb-8 text-center text-[#ac764e]">Edit Blog Post</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="blogForm">
                @csrf
                @method('PUT')

                {{-- Cafe Name --}}
                <div class="mb-6">
                    <label for="cafe_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Cafe Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="cafe_name" name="cafe_name" value="{{ old('cafe_name', $post->cafe_name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('cafe_name') border-red-500 @enderror"
                           required>
                    @error('cafe_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location', $post->location) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('location') border-red-500 @enderror"
                           required>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opening Hours --}}
                <div class="mb-6">
                    <label for="opening_hours" class="block text-sm font-medium text-gray-700 mb-2">
                        Opening Hours <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="opening_hours" name="opening_hours" value="{{ old('opening_hours', $post->opening_hours) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('opening_hours') border-red-500 @enderror"
                           required>
                    @error('opening_hours')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('description') border-red-500 @enderror"
                              required>{{ old('description', $post->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Blogger Recommendations --}}
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="blogger_top_drink" class="block text-sm font-medium text-gray-700 mb-2">
                            Top Drink Recommendation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="blogger_top_drink" name="blogger_top_drink" value="{{ old('blogger_top_drink', $post->blogger_top_drink) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('blogger_top_drink') border-red-500 @enderror"
                               required>
                        @error('blogger_top_drink')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="blogger_top_food" class="block text-sm font-medium text-gray-700 mb-2">
                            Top Food Recommendation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="blogger_top_food" name="blogger_top_food" value="{{ old('blogger_top_food', $post->blogger_top_food) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('blogger_top_food') border-red-500 @enderror"
                               required>
                        @error('blogger_top_food')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Scores Section --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-[#ac764e] mb-4">Ratings (1-10)</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label for="score_affordability" class="block text-sm font-medium text-gray-700 mb-2">
                                    Affordability <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="score_affordability" name="score_affordability"
                                       min="1" max="10" value="{{ old('score_affordability', $post->score_affordability) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('score_affordability') border-red-500 @enderror"
                                       required onchange="calculateOverallScore()">
                                @error('score_affordability')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="score_ambiance" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ambiance <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="score_ambiance" name="score_ambiance"
                                       min="1" max="10" value="{{ old('score_ambiance', $post->score_ambiance) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('score_ambiance') border-red-500 @enderror"
                                       required onchange="calculateOverallScore()">
                                @error('score_ambiance')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="score_taste" class="block text-sm font-medium text-gray-700 mb-2">
                                    Taste <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="score_taste" name="score_taste"
                                       min="1" max="10" value="{{ old('score_taste', $post->score_taste) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#ac764e] @error('score_taste') border-red-500 @enderror"
                                       required onchange="calculateOverallScore()">
                                @error('score_taste')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="score_overall" class="block text-sm font-medium text-gray-700 mb-2">
                                    Overall Score <span class="text-sm text-gray-500">(Auto-calculated)</span>
                                </label>
                                <input type="number" id="score_overall" name="score_overall"
                                       min="1" max="10" value="{{ old('score_overall', $post->score_overall) }}" step="0.1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed"
                                       placeholder="Auto-calculated" readonly>
                                @error('score_overall')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">This is automatically calculated as the average of the three scores above.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Images Section --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Images
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                        @forelse($post->pictures as $picture)
                            <div class="relative" id="pic-{{ $picture->id }}">
                                <img src="{{ asset($picture->picture_path) }}" class="w-full h-24 object-cover rounded-lg border-2 border-[#ac764e]" alt="Blog Image">
                                <input type="checkbox" name="remove_pictures[]" value="{{ $picture->id }}" id="remove-pic-{{ $picture->id }}" class="hidden">
                                <button type="button"
                                    onclick="removeImage({{ $picture->id }})"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer text-xs"
                                    title="Remove">
                                    ×
                                </button>
                            </div>
                        @empty
                            <div class="text-gray-500">No Images</div>
                        @endforelse
                    </div>
                    <label for="pictures" class="block text-sm font-medium text-gray-700 mb-2">
                        Add Images (Optional, Max 5)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-[#ac764e] transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="pictures" class="relative cursor-pointer bg-white rounded-md font-medium text-[#ac764e] hover:text-[#8b5c36] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#ac764e]">
                                    <span>Upload files</span>
                                    <input id="pictures" name="pictures[]" type="file" class="sr-only" multiple accept="image/*" max="5">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB each</p>
                        </div>
                    </div>
                    @error('pictures')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('pictures.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 hidden"></div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('home') }}"
                       class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition">
                        Cancel
                    </a>

                    <button type="submit" id="submitBtn"
                            class="bg-[#ac764e] text-white px-8 py-2 rounded-md hover:bg-[#8b5c36] transition font-semibold">
                        Update Blog Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript for Image Preview and Score Calculation --}}
    <script>
        function calculateOverallScore() {
            const affordability = parseFloat(document.getElementById('score_affordability').value) || 0;
            const ambiance = parseFloat(document.getElementById('score_ambiance').value) || 0;
            const taste = parseFloat(document.getElementById('score_taste').value) || 0;
            if (affordability > 0 && ambiance > 0 && taste > 0) {
                const average = (affordability + ambiance + taste) / 3;
                document.getElementById('score_overall').value = Math.round(average * 10) / 10;
            } else {
                document.getElementById('score_overall').value = '';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            calculateOverallScore();
        });

        // Image preview functionality
        document.getElementById('pictures').addEventListener('change', function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';
            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
                for (let i = 0; i < Math.min(files.length, 5); i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-[#ac764e]" alt="Preview">
                                <div class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer text-xs" onclick="removePreview(this, ${i})">×</div>
                            `;
                            previewContainer.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        });

        function removePreview(element, index) {
            element.parentElement.remove();
        }

        function removeImage(id) {
            document.getElementById('remove-pic-' + id).checked = true;
            document.getElementById('pic-' + id).style.display = 'none';
        }

        document.getElementById('blogForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Updating...';
        });
    </script>
</x-layout>