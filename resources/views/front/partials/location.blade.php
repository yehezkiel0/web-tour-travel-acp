<div id="location" class="tab-pane md:col-span-2">
    <h2 class="text-2xl font-semibold mb-7">Location</h2>
    <div class="location-map mb-7">
        {!! $destination->destination_detail->map_url !!}
    </div>
    <div class="list-features text-gray-2">
        <h4 class="text-lg font-semibold mb-4">Arrival</h4>
        <ul>
            <li>{{ $destination->destination_detail->arrival }}</li>
        </ul>
    </div>
    <div class="list-features text-gray-2">
        <h4 class="text-lg font-semibold mb-4">Departure</h4>
        <ul>
            <li>{{ $destination->destination_detail->departure }}</li>
        </ul>
    </div>
    <div class="list-features text-gray-2">
        <h4 class="text-lg font-semibold mb-4">Hotels</h4>
        <ul>
            <li>{{ $destination->destination_detail->nearby_hotel }}</li>
        </ul>
    </div>
</div>
