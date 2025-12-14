@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        {{-- Header --}}
        <header class="flex-col mb-4 sm:mb-6 lg:mb-7 space-y-2 sm:space-y-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse text-xs sm:text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex gap-x-1 sm:gap-x-2 items-center font-medium text-gray-3 hover:underline">
                        <img src="{{ asset('images/icon/Home.svg') }}" alt="home-icon" class="w-3 h-3 sm:w-4 sm:h-4">
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 font-medium text-primary md:ms-2 truncate max-w-[200px] sm:max-w-none">{{ $destination->title }}</a>
                    </div>
                </li>
            </ol>
        </header>

        {{-- Gallery Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 sm:gap-3 lg:gap-4 mb-4 sm:mb-6 lg:mb-7">
            {{-- Main Image --}}
            <div class="relative md:col-span-2">
                <img src="{{ Storage::url($destination->featured_photo) }}" alt="{{ $destination->title }}"
                    class="w-full h-[250px] sm:h-[300px] md:h-[350px] lg:h-[400px] object-cover rounded-lg" />
            </div>

            {{-- Gallery Grid --}}
            <div id="gallery" class="grid grid-cols-2 md:grid-cols-1 gap-2 sm:gap-3 lg:gap-4"
                data-photos='@json($destination_photos->pluck('photo'))'>
                @foreach ($destination_photos as $index => $photo)
                    @if ($index < 1)
                        <div class="relative">
                            <img src="{{ Storage::url($photo->photo) }}"
                                alt="{{ $destination->title }} gallery image {{ $index + 1 }}"
                                class="w-full h-32 sm:h-40 md:h-48 object-cover rounded-lg" />
                        </div>
                    @elseif ($index === 1)
                        <div class="relative cursor-pointer" id="openGalleryModal">
                            <img src="{{ Storage::url($photo->photo) }}"
                                alt="{{ $destination->title }} gallery image {{ $index + 1 }}"
                                class="w-full h-32 sm:h-40 md:h-48 object-cover rounded-lg brightness-50" />
                            <div class="absolute inset-0 flex items-center justify-center bg-opacity-50 rounded-lg">
                                <span class="text-white text-sm sm:text-base lg:text-xl font-semibold">See All Photos</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- Modal untuk Galeri -->
            <div id="galleryModal"
                class="hidden fixed inset-0 bg-gray-1 bg-opacity-80 items-center justify-center z-50 transition-all ease-in-out duration-300 p-4">
                <div class="relative w-full max-h-full max-w-xl md:max-w-4xl">
                    <div class="bg-opacity-100">
                        <!-- Tombol Close -->
                        <button id="closeGalleryModal"
                            class="absolute -top-8 sm:-top-10 -right-2 sm:-right-3 text-gray-4 text-xl sm:text-2xl px-2 py-1 rounded-md z-10">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Navigasi Foto -->
                        <div class="relative flex justify-center text-gray-4">
                            <img id="currentPhoto" alt="Current gallery image"
                                class="w-full h-48 sm:h-56 md:h-96 object-cover rounded-md">
                            <button id="prevPhoto"
                                class="absolute top-1/2 -left-6 sm:-left-10 transform -translate-y-1/2 text-2xl sm:text-3xl">
                                <i class="fa-solid fa-circle-chevron-left"></i>
                            </button>
                            <button id="nextPhoto"
                                class="absolute top-1/2 -right-6 sm:-right-10 transform -translate-y-1/2 text-2xl sm:text-3xl">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="border-b mb-6 lg:mb-10 overflow-x-auto scrollbar-hide">
            <nav class="flex gap-x-4 sm:gap-x-6 lg:gap-x-8 z-10 text-xs sm:text-sm font-medium text-gray-1 min-w-max"
                id="destinationTabs">
                <button data-tab="overview"
                    class="tab-btn active py-3 sm:py-4 px-2 custom-border whitespace-nowrap">Overview</button>
                <button data-tab="price" class="tab-btn py-3 sm:py-4 px-2 custom-border whitespace-nowrap">Price</button>
                <button data-tab="itinerary"
                    class="tab-btn py-3 sm:py-4 px-2 custom-border whitespace-nowrap">Itinerary</button>
                <button data-tab="location"
                    class="tab-btn py-3 sm:py-4 px-2 custom-border whitespace-nowrap">Location</button>
                <button data-tab="notes" class="tab-btn py-3 sm:py-4 px-2 custom-border whitespace-nowrap">Notes</button>
                @if ($destination->virtual_tour_images)
                    <button data-tab="virtual-tour"
                        class="tab-btn py-3 sm:py-4 px-2 custom-border whitespace-nowrap text-primary"><i
                            class="fas fa-cube mr-1"></i> Virtual Tour</button>
                @endif
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="space-y-6 lg:space-y-8 text-gray-1 lg:col-span-2 order-2 lg:order-1">
                @include('front.partials.overview')
                @include('front.partials.price')
                @include('front.partials.itinerary')
                @include('front.partials.location')
                @include('front.partials.location')
                @include('front.partials.notes')
                @include('front.partials.virtual-tour')
            </div>

            <div class="bg-white rounded-2xl w-full border h-fit order-1 lg:order-2 sticky top-20 lg:top-24">
                {{-- Add to Itinerary Button --}}
                @auth
                    <div class="px-5 sm:px-7 pt-4 pb-2">
                        <button onclick="openItineraryModal()"
                            class="w-full bg-secondary text-gray-800 font-semibold py-3 rounded-xl hover:bg-yellow-400 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus"></i> Add to Itinerary
                        </button>
                    </div>
                @endauth

                <h3 class="text-lg sm:text-xl font-semibold text-gray-1 px-5 sm:px-7 py-4 sm:py-6">Start Booking</h3>
                <hr>
                <form action="{{ route('booking_form', $destination->slug) }}" method="POST" class="booking-form">
                    @csrf
                    <div class="space-y-4 sm:space-y-6 px-5 sm:px-7 py-4 sm:py-6">
                        {{-- Date --}}
                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label id="from-date"
                                    class="block text-gray-1 text-sm sm:text-base font-medium mb-2">From</label>
                                <div class="relative">
                                    <input type="text" name="from_date" id="from_date"
                                        class="w-full px-3 sm:px-[18px] py-2.5 sm:py-3 text-sm sm:text-base bg-gray-6 border border-gray-5 rounded-md text-gray-4 focus:outline-primary-400">
                                    <img src="{{ asset('images/icon/calender.svg') }}" class="calender-icon"
                                        alt="calendar">
                                </div>
                            </div>
                            <div>
                                <label id="to-date"
                                    class="block text-gray-1 text-sm sm:text-base font-medium mb-2">To</label>
                                <div class="relative">
                                    <input type="text" name="to_date" id="to_date"
                                        class="w-full px-3 sm:px-[18px] py-2.5 sm:py-3 text-sm sm:text-base bg-gray-6 border border-gray-5 rounded-md text-gray-4 focus:outline-primary-400">
                                    <img src="{{ asset('images/icon/calender.svg') }}" class="calender-icon"
                                        alt="calendar">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3 class="text-gray-1 text-sm sm:text-base font-medium">Add Traveller</h3>

                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="space-y-2 flex-1">
                                    <span class="text-gray-2 text-xs font-medium">Adult</span>
                                    <div class="flex items-center relative">
                                        <button type="button"
                                            class="decrease-adult absolute top-0 left-0 w-7 h-7 sm:w-8 sm:h-8 bg-primary text-white text-sm sm:text-base rounded-lg flex items-center justify-center">-</button>
                                        <input type="number" name="adult_count" id="adult-count" value="1"
                                            class="w-full h-7 sm:h-8 text-sm sm:text-base text-center bg-primary-50 rounded-lg"
                                            disabled>
                                        <button type="button"
                                            class="increase-adult absolute top-0 right-0 w-7 h-7 sm:w-8 sm:h-8 bg-primary text-white text-sm sm:text-base rounded-lg flex items-center justify-center">+</button>
                                    </div>
                                </div>

                                <div class="space-y-2 flex-1">
                                    <span class="text-gray-2 text-xs font-medium">Child</span>
                                    <div class="relative">
                                        <button type="button"
                                            class="decrease-child absolute top-0 left-0 w-7 h-7 sm:w-8 sm:h-8 bg-primary text-white text-sm sm:text-base rounded-lg flex items-center justify-center">-</button>
                                        <input type="number" name="child_count" id="child-count" value="0"
                                            class="w-full h-7 sm:h-8 text-sm sm:text-base text-center bg-primary-50 rounded-lg"
                                            disabled>
                                        <button type="button"
                                            class="increase-child absolute top-0 right-0 w-7 h-7 sm:w-8 sm:h-8 bg-primary text-white text-sm sm:text-base rounded-lg flex items-center justify-center">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 sm:pt-4 flex flex-col items-center">
                            <span class="text-gray-3 font-medium text-xs sm:text-sm mb-2">Subtotal</span>
                            <p id="total-price" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-primary w-fit"
                                data-total-price="{{ $destination->price }}">
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full text-white text-sm sm:text-base py-3 sm:py-4 rounded-[10px] font-bold border border-primary bg-primary hover:bg-primary-400 transition-all ease-in-out duration-300">
                            Book Now
                        </button>

                        <p class="text-gray-3 text-[8px] sm:text-[9px] text-center">*The price shown is an estimate and
                            subject to
                            change.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        {{-- Reviews Section --}}
        <div class="mt-12 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Reviews & Ratings</h2>
                    @if ($destination->totalReviews() > 0)
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fa{{ $i <= round($destination->averageRating()) ? 's' : 'r' }} fa-star text-yellow-400"></i>
                                @endfor
                            </div>
                            <span
                                class="text-lg font-semibold">{{ number_format($destination->averageRating(), 1) }}</span>
                            <span class="text-gray-600">({{ $destination->totalReviews() }} reviews)</span>
                        </div>
                    @endif
                </div>
                @auth
                    <button onclick="openReviewModal()"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">
                        <i class="fas fa-star mr-2"></i>Write a Review
                    </button>
                @else
                    <a href="{{ route('user.login') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">
                        <i class="fas fa-star mr-2"></i>Login to Review
                    </a>
                @endauth
            </div>

            {{-- Reviews List --}}
            <div class="space-y-4" id="reviewsList">
                @forelse($destination->reviews()->where('is_approved', true)->latest()->take(5)->get() as $review)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&size=100&background=3477F6&color=fff"
                                    alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-yellow-400 text-sm"></i>
                                            @endfor
                                        </div>
                                        @if ($review->is_verified)
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Verified
                                                Purchase</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <h5 class="font-semibold text-gray-900 mb-2">{{ $review->title }}</h5>
                        <p class="text-gray-700 mb-3">{{ $review->review }}</p>

                        @if ($review->photos && count($review->photos) > 0)
                            <div class="flex gap-2 mb-3">
                                @foreach ($review->photos as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Review photo"
                                        class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-75"
                                        onclick="window.open('{{ asset('storage/' . $photo) }}', '_blank')">
                                @endforeach
                            </div>
                        @endif

                        <button onclick="markHelpful({{ $review->id }}, this)"
                            class="text-sm text-gray-600 hover:text-blue-600">
                            <i class="far fa-thumbs-up mr-1"></i>
                            Helpful (<span class="helpful-count">{{ $review->helpful_count }}</span>)
                        </button>
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <i class="fas fa-star text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600">No reviews yet. Be the first to review!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Review Modal --}}
    <div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Write a Review</h3>
                    <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <form action="{{ route('review.store', $destination->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                            <div class="flex gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating({{ $i }})"
                                        class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors">
                                        <i class="far fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                placeholder="Summarize your experience">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Review *</label>
                            <textarea name="review" rows="4" required class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                placeholder="Share your experience with others..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photos (Optional, max 5)</label>
                            <input type="file" name="photos[]" multiple accept="image/*"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <p class="text-xs text-gray-500 mt-1">Max 2MB per image</p>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                                Submit Review
                            </button>
                            <button type="button" onclick="closeReviewModal()"
                                class="px-6 bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openReviewModal() {
                document.getElementById('reviewModal').classList.remove('hidden');
            }

            function closeReviewModal() {
                document.getElementById('reviewModal').classList.add('hidden');
            }

            function setRating(rating) {
                document.getElementById('ratingInput').value = rating;
                const stars = document.querySelectorAll('.rating-star');
                stars.forEach((star, index) => {
                    const icon = star.querySelector('i');
                    if (index < rating) {
                        icon.classList.remove('far', 'text-gray-300');
                        icon.classList.add('fas', 'text-yellow-400');
                    } else {
                        icon.classList.remove('fas', 'text-yellow-400');
                        icon.classList.add('far', 'text-gray-300');
                    }
                });
            }

            function markHelpful(reviewId, button) {
                fetch(`/review/${reviewId}/helpful`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            button.querySelector('.helpful-count').textContent = data.count;
                            button.disabled = true;
                            button.classList.add('text-blue-600');
                        }
                    });
            }
        </script>
    @endpush




    @include('front.layout.footer')

    {{-- Itinerary Modal --}}
    @auth
        <div id="itineraryModal"
            class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Add to Itinerary</h3>
                    <button onclick="closeItineraryModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if (isset($userItineraries) && $userItineraries->count() > 0)
                    <div class="space-y-3 max-h-[60vh] overflow-y-auto mb-4">
                        @foreach ($userItineraries as $itinerary)
                            <button onclick="addToItinerary({{ $itinerary->id }}, {{ $destination->id }})"
                                class="w-full text-left p-3 rounded-lg border hover:bg-blue-50 hover:border-blue-300 transition flex justify-between items-center group">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $itinerary->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $itinerary->items->count() }} items •
                                        {{ $itinerary->start_date ? $itinerary->start_date->format('M d') : 'No Date' }}</p>
                                </div>
                                <i class="fa-solid fa-plus text-primary opacity-0 group-hover:opacity-100 transition"></i>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500 mb-4">You don't have any itineraries yet.</p>
                        <a href="{{ route('itineraries.create') }}" class="text-primary font-semibold hover:underline">Create
                            New Itinerary</a>
                    </div>
                @endif
            </div>
        </div>

        <script>
            function openItineraryModal() {
                document.getElementById('itineraryModal').classList.remove('hidden');
            }

            function closeItineraryModal() {
                document.getElementById('itineraryModal').classList.add('hidden');
            }

            function addToItinerary(itineraryId, destinationId) {
                fetch('{{ route('itinerary.add_item') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            itinerary_id: itineraryId,
                            destination_id: destinationId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            iziToast.success({
                                title: 'Success',
                                message: 'Added to itinerary!',
                                position: 'topRight'
                            });
                            closeItineraryModal();
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'Failed to add to itinerary',
                                position: 'topRight'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong',
                            position: 'topRight'
                        });
                    });
            }
        </script>
    @endauth
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css" />
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (isset($destination->virtual_tour_images) && count($destination->virtual_tour_images) > 0)
                    // Defer initialization until tab is clicked to ensure container has dimensions
                    const virtualTourTabBtn = document.querySelector('button[data-tab="virtual-tour"]');
                    let viewerInitialized = false;

                    if (virtualTourTabBtn) {
                        virtualTourTabBtn.addEventListener('click', function() {
                            if (!viewerInitialized) {
                                setTimeout(() => {
                                    pannellum.viewer('panorama', {
                                        "type": "equirectangular",
                                        "panorama": "{{ Storage::url($destination->virtual_tour_images[0]) }}",
                                        "autoLoad": true,
                                        "compass": true,
                                        "showControls": true
                                    });
                                    viewerInitialized = true;
                                }, 200); // Small delay for layout
                            }
                        });
                    }

                    window.loadScene = function(url) {
                        pannellum.viewer('panorama', {
                            "type": "equirectangular",
                            "panorama": url,
                            "autoLoad": true,
                            "compass": true,
                            "showControls": true
                        });
                    }
                @endif
            });
        </script>
    @endpush
@endsection
