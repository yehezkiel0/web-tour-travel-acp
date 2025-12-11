<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingSettingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('pricing_settings')->insert([
      'individual_visa_rate' => 650000.00, // IDR 650,000
      'group_visa_rate' => 500000.00,      // IDR 500,000
      'tax_percentage' => 11.00,           // 11% tax
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
