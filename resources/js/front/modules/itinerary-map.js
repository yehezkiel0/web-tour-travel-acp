export const initItineraryMap = () => {
    const mapContainer = document.getElementById("itinerary-map");

    // Check if map container exists and has valid dimensions
    if (!mapContainer) return;

    // Get locations data
    let locations = [];
    try {
        locations = JSON.parse(mapContainer.dataset.locations || "[]");
    } catch (e) {
        console.error("Failed to parse map locations", e);
        return;
    }

    // Filter out items without valid coordinates
    locations = locations.filter((loc) => loc.lat && loc.lng);

    if (locations.length === 0) {
        // Handle empty or invalid locations visually
        mapContainer.innerHTML =
            '<div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-500 text-sm">No map data available</div>';
        return;
    }

    // Initialize Map
    // Default centers if single point, otherwise bounds will handle it
    const map = L.map("itinerary-map").setView(
        [locations[0].lat, locations[0].lng],
        13
    );

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "© OpenStreetMap",
    }).addTo(map);

    const markers = [];
    const latLngs = [];

    // Custom Icon (Optional, default is fine for now but sometimes fails due to path issues in bundlers)
    // Fix for default marker icon missing in some builds
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl:
            "https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png",
        iconUrl: "https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png",
        shadowUrl:
            "https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png",
    });

    locations.forEach((loc, index) => {
        const marker = L.marker([loc.lat, loc.lng]).addTo(map);

        // Popup Content
        const popupContent = `
            <div class="text-center min-w-[150px]">
                <img src="${
                    loc.image
                }" class="w-full h-24 object-cover rounded mb-2" onerror="this.style.display='none'">
                <h4 class="font-bold text-sm mb-1">${loc.title}</h4>
                <span class="text-xs bg-primary text-white px-2 py-0.5 rounded-full">Stop #${
                    index + 1
                }</span>
            </div>
        `;

        marker.bindPopup(popupContent);
        markers.push(marker);
        latLngs.push([loc.lat, loc.lng]);
    });

    if (latLngs.length > 1) {
        // Draw Polyline
        const polyline = L.polyline(latLngs, {
            color: "#2563EB", // Primary Blue
            weight: 3,
            opacity: 0.7,
            dashArray: "5, 10",
            lineCap: "round",
        }).addTo(map);

        // Fit bounds to show all points
        map.fitBounds(polyline.getBounds(), { padding: [50, 50] });
    } else {
        // Single point
        map.setView(latLngs[0], 13);
    }

    // Fix for map not rendering correctly in some layout shifts (e.g. tabs or dynamic loading)
    setTimeout(() => {
        map.invalidateSize();
    }, 100);
};
