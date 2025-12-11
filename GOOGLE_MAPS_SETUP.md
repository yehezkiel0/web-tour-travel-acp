# Google Maps Integration

## Setup Instructions

The application now uses latitude and longitude coordinates to display Google Maps for destinations and hotels.

### Getting a Google Maps API Key

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the **Maps Embed API**
4. Go to **Credentials** and create an API key
5. Restrict the API key to your domain for security

### Configure the Application

Add your Google Maps API key to `.env`:

```env
GOOGLE_MAPS_API_KEY=your_api_key_here
```

The views will automatically use the API key from config. If no API key is configured, a helpful message will be displayed with a link to get one.

### Database Structure

-   **destinations** table: `latitude`, `longitude` (decimal 10,8)
-   **hotels** table: `latitude`, `longitude` (decimal 10,8)

### Admin Panel

Administrators can now:

-   Add latitude/longitude when creating new destinations/hotels
-   Edit latitude/longitude for existing destinations/hotels
-   Leave empty if location is not available (fallback message will be shown)

### Seeder Data

Run the seeder to populate sample location data:

```bash
php artisan db:seed --class=LocationDataSeeder
```

This will update 8 destinations and 10 hotels with real South Korea coordinates.

### Front-end Display

-   **Destinations**: Location tab shows embedded Google Map using lat/lng coordinates
-   **Hotels**: Location tab shows embedded Google Map using lat/lng coordinates
-   **No API Key**: Shows message "Google Maps API key not configured" with coordinates and link to get API key
-   **No Coordinates**: Shows "Map not available" message

### Troubleshooting

**403 Error on Google Maps:**

-   Make sure `GOOGLE_MAPS_API_KEY` is set in `.env`
-   Run `php artisan config:clear` to clear config cache
-   Verify the API key has Maps Embed API enabled
-   Check API key restrictions (HTTP referrers)

**Missing Photos (403 errors):**

-   Check if storage link exists: `php artisan storage:link`
-   Clean missing photo records: `php artisan photos:check`
-   Upload photos through admin panel
