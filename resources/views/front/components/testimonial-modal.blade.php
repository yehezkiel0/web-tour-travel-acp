<!-- Testimonial Modal -->
<div id="testimonialModal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden items-center justify-center">
    <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">Share Your Experience</h3>
                <button onclick="closeTestimonialModal()" class="text-white hover:text-gray-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data"
            class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="service_type" id="service_type" value="{{ $serviceType }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Name *</label>
                    <input type="text" name="name" required
                        value="{{ auth()->check() ? auth()->user()->name : old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                    <input type="text" name="location" required value="{{ old('location') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Jakarta, Indonesia">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Your Photo</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    onchange="previewPhoto(event)">
                <div id="photoPreview" class="mt-2 hidden">
                    <img src="" alt="Preview" class="w-24 h-24 rounded-full object-cover">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                <div class="flex gap-2" id="ratingStars">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})"
                            class="rating-star text-3xl transition hover:scale-110" data-rating="{{ $i }}">
                            ☆
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingValue" value="5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Testimonial Title *</label>
                <input type="text" name="title" required value="{{ old('title') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Exceptional Service">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Your Message * <span
                        class="text-xs text-gray-500">(Max 1000 characters)</span></label>
                <textarea name="message" required rows="5" maxlength="1000"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Share your experience with us...">{{ old('message') }}</textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeTestimonialModal()"
                    class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition">
                    Submit Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openTestimonialModal() {
        document.getElementById('testimonialModal').classList.remove('hidden');
        document.getElementById('testimonialModal').classList.add('flex');
        // Set all stars to filled by default (5 stars)
        setRating(5);
    }

    function closeTestimonialModal() {
        document.getElementById('testimonialModal').classList.add('hidden');
        document.getElementById('testimonialModal').classList.remove('flex');
    }

    function setRating(rating) {
        document.getElementById('ratingValue').value = rating;
        const stars = document.querySelectorAll('.rating-star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.textContent = '★';
                star.classList.add('text-yellow-400');
            } else {
                star.textContent = '☆';
                star.classList.remove('text-yellow-400');
            }
        });
    }

    function previewPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photoPreview');
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Close modal when clicking outside
    document.getElementById('testimonialModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeTestimonialModal();
        }
    });
</script>
