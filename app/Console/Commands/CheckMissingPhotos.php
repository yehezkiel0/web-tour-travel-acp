<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckMissingPhotos extends Command
{
  protected $signature = 'photos:check';
  protected $description = 'Check for missing destination and hotel photos';

  public function handle()
  {
    $this->info('Checking destination photos...');

    $photos = DB::table('destination_photos')->get();
    $missing = [];
    $existing = 0;

    foreach ($photos as $photo) {
      if (!Storage::disk('public')->exists($photo->photo)) {
        $missing[] = $photo;
      } else {
        $existing++;
      }
    }

    $this->info("Existing photos: {$existing}");
    $this->warn("Missing photos: " . count($missing));

    if (count($missing) > 0) {
      $this->newLine();
      $this->warn('Missing photo files:');
      foreach (array_slice($missing, 0, 10) as $photo) {
        $this->line("  - ID: {$photo->id}, Path: {$photo->photo}");
      }

      if (count($missing) > 10) {
        $this->line("  ... and " . (count($missing) - 10) . " more");
      }

      $this->newLine();
      if ($this->confirm('Delete missing photo records from database?')) {
        foreach ($missing as $photo) {
          DB::table('destination_photos')->where('id', $photo->id)->delete();
        }
        $this->info('Deleted ' . count($missing) . ' missing photo records.');
      }
    }

    return 0;
  }
}
