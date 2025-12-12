@props(['type', 'id', 'inWishlist' => false])

<button type="button" onclick="toggleWishlist('{{ $type }}', {{ $id }}, this)"
    class="wishlist-btn group flex items-center justify-center w-10 h-10 bg-white hover:bg-red-50 rounded-full shadow-md transition-all duration-300 hover:scale-110"
    data-type="{{ $type }}" data-id="{{ $id }}" data-in-wishlist="{{ $inWishlist ? 'true' : 'false' }}"
    title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}">
    <svg class="w-6 h-6 transition-all duration-300 {{ $inWishlist ? 'text-red-500 fill-current' : 'text-gray-400 group-hover:text-red-500' }}"
        fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
</button>

@once
    @push('scripts')
        <script>
            function toggleWishlist(type, id, button) {
                @guest
                window.location.href = '{{ route('login') }}';
                return;
            @endguest

            const svg = button.querySelector('svg');
            const isInWishlist = button.dataset.inWishlist === 'true';

            fetch('{{ route('wishlist.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type,
                        id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        svg.classList.remove('text-gray-400');
                        svg.classList.add('text-red-500', 'fill-current');
                        svg.setAttribute('fill', 'currentColor');
                        button.dataset.inWishlist = 'true';
                        button.setAttribute('title', 'Remove from wishlist');
                        showNotification(data.message, 'success');
                    } else {
                        svg.classList.remove('text-red-500', 'fill-current');
                        svg.classList.add('text-gray-400');
                        svg.setAttribute('fill', 'none');
                        button.dataset.inWishlist = 'false';
                        button.setAttribute('title', 'Add to wishlist');
                        showNotification(data.message, 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Something went wrong!', 'error');
                });
            }

            function showNotification(message, type) {
                // Simple notification using iziToast if available, otherwise alert
                if (typeof iziToast !== 'undefined') {
                    iziToast[type === 'success' ? 'success' : type === 'error' ? 'error' : 'info']({
                        message: message,
                        position: 'topRight'
                    });
                } else {
                    alert(message);
                }
            }
        </script>
    @endpush
@endonce
