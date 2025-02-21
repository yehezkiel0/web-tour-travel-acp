<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6">
            <h1 class="text-2xl font-bold">Booking Confirmation</h1>
            <p class="mt-2">Thank you for booking with us!</p>
        </div>

        <!-- Booking Details -->
        <div class="p-6 space-y-6">
            <!-- Customer Info -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Customer Details</h2>
                <div class="grid grid-cols-2 gap-4 text-gray-600">
                    <div>
                        <p class="font-medium">Name: {{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Email: {{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Tour Details -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Tour Details</h2>
                <div class="grid grid-cols-2 gap-4 text-gray-600">
                    <div>
                        <p class="font-medium">Destination: {{ $destination->title }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Date: {{ formatDate($destination->date_started, 'd F Y') }} -
                            {{ formatDate($destination->date_ended, 'd F Y') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Number of Guests:
                            {{ $transaction->adult_count + $transaction->child_count }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Total Price: {{ formatIDR($transaction->total_price) }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking ID -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-center text-gray-700">
                    <span class="font-medium">Booking ID:</span>
                    <span class="font-mono">{{ $transaction->code }}</span>
                </p>
            </div>

            <!-- QR Code (if needed) -->
            <div class="flex justify-center">
                {!! QrCode::size(150)->generate($transaction->code) !!}
            </div>

            <!-- Important Notes -->
            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Important Information</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Please arrive 30 minutes before the scheduled time</li>
                    <li>Don't forget to bring this ticket (digital or printed)</li>
                    <li>Valid ID is required for verification</li>
                    <li>For any questions, contact our support team</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 p-6 text-center text-gray-500 text-sm">
            <p>This is an automated email, please do not reply.</p>
            <p class="mt-2">© {{ date('Y') }} Your Travel Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
