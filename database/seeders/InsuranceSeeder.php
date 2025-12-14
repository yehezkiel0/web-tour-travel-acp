<?php

namespace Database\Seeders;

use App\Models\Insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
  public function run(): void
  {
    Insurance::create([
      'name' => 'Basic Protection',
      'description' => 'Bagasi hilang & Delay penerbangan',
      'price' => 50000,
      'type' => 'basic',
    ]);

    Insurance::create([
      'name' => 'Premium Coverage',
      'description' => 'Medis, Kecelakaan, Bagasi & Pembatalan',
      'price' => 150000,
      'type' => 'premium',
    ]);
  }
}
