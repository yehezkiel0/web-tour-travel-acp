<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obj = new User();
        $obj->name = 'Admin';
        $obj->email = 'admin123@gmail.com';
        $obj->photo = "";
        $obj->password = Hash::make('12345678');
        $obj->role = 'admin';
        $obj->status = 1;
        $obj->token = "";
        $obj->save();
    }
}
