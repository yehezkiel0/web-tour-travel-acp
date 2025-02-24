<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Destination;
use App\Models\DestinationPhoto;

class MigrateUploads extends Command
{
    protected $signature = 'migrate:uploads';
    protected $description = 'Migrate files from public/uploads to storage';

    public function handle()
    {
        $this->info('Starting migration...');

        // Buat direktori jika belum ada
        Storage::disk('public')->makeDirectory('destinations');
        Storage::disk('public')->makeDirectory('destination_photos');

        // Migrasi featured photos
        $destinations = Destination::all();
        $this->info('Migrating ' . $destinations->count() . ' featured photos...');

        foreach ($destinations as $destination) {
            if ($destination->featured_photo && file_exists(public_path('uploads/' . $destination->featured_photo))) {
                // Salin file
                File::copy(
                    public_path('uploads/' . $destination->featured_photo),
                    storage_path('app/public/destinations/' . $destination->featured_photo)
                );

                // Update database
                $destination->featured_photo = 'destinations/' . $destination->featured_photo;
                $destination->save();

                $this->line('Migrated: ' . $destination->featured_photo);
            }
        }

        // Migrasi gallery photos
        $photos = DestinationPhoto::all();
        $this->info('Migrating ' . $photos->count() . ' gallery photos...');

        foreach ($photos as $photo) {
            if ($photo->photo && file_exists(public_path('uploads/' . $photo->photo))) {
                // Salin file
                File::copy(
                    public_path('uploads/' . $photo->photo),
                    storage_path('app/public/destination_photos/' . $photo->photo)
                );

                // Update database
                $photo->photo = 'destination_photos/' . $photo->photo;
                $photo->save();

                $this->line('Migrated: ' . $photo->photo);
            }
        }

        $this->info('Migration completed!');
    }
}