<!-- Newsletter Subscription Section -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-6">
                <i class="fas fa-envelope text-white text-5xl mb-4"></i>
                <h3 class="text-3xl font-bold text-white mb-3">Subscribe to Our Newsletter</h3>
                <p class="text-blue-100 text-lg">Get exclusive travel deals, tips, and destination guides delivered to
                    your inbox!</p>
            </div>

            <form id="newsletterForm" class="max-w-md mx-auto">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="email" name="email" id="newsletterEmail" placeholder="Enter your email address"
                            required
                            class="w-full px-6 py-4 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white">
                    </div>
                    <button type="submit"
                        class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Subscribe</span>
                    </button>
                </div>
                <p class="text-blue-100 text-sm mt-3">We respect your privacy. Unsubscribe anytime.</p>
            </form>

            <!-- Success Message -->
            <div id="newsletterSuccess"
                class="hidden mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Thank you for subscribing! Check your inbox for confirmation.</span>
            </div>

            <!-- Error Message -->
            <div id="newsletterError"
                class="hidden mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span id="newsletterErrorMessage">Something went wrong. Please try again.</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const email = document.getElementById('newsletterEmail').value;
            const submitBtn = form.querySelector('button[type="submit"]');
            const successDiv = document.getElementById('newsletterSuccess');
            const errorDiv = document.getElementById('newsletterError');
            const errorMessage = document.getElementById('newsletterErrorMessage');

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Subscribing...';

            // Hide previous messages
            successDiv.classList.add('hidden');
            errorDiv.classList.add('hidden');

            fetch('{{ route('newsletter.subscribe') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successDiv.classList.remove('hidden');
                        form.reset();

                        // Show iziToast if available
                        if (typeof iziToast !== 'undefined') {
                            iziToast.success({
                                message: data.message,
                                position: 'topRight'
                            });
                        }
                    } else {
                        errorMessage.textContent = data.message;
                        errorDiv.classList.remove('hidden');

                        if (typeof iziToast !== 'undefined') {
                            iziToast.error({
                                message: data.message,
                                position: 'topRight'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.textContent = 'An error occurred. Please try again.';
                    errorDiv.classList.remove('hidden');

                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({
                            message: 'An error occurred. Please try again.',
                            position: 'topRight'
                        });
                    }
                })
                .finally(() => {
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Subscribe</span>';
                });
        });
    </script>
@endpush
