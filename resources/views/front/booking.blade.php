@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <div class="bg-white">
        <h1>Booking</h1>
        <p>From: {{ $bookingData['from_date'] }}</p>
        <p>To: {{ $bookingData['to_date'] }}</p>
        <p>Adults: {{ $bookingData['adult_count'] }}</p>
        <p>Children: {{ $bookingData['child_count'] }}</p>
        <p>Total Price: IDR {{ number_format($bookingData['total_price'], 0, ',', '.') }}</p>
    </div>
    @include('front.layout.footer')
@endsection
