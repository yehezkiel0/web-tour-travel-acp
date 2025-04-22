<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->string('photo')->nullable()->after('email');
        });

        // Migrate admin users to the users table
        $admins = DB::table('admins')->get();
        foreach ($admins as $admin) {
            DB::table('users')->insert([
                'name' => $admin->name,
                'email' => $admin->email,
                'photo' => $admin->photo,
                'password' => $admin->password,
                'role' => 'admin',
                'status' => 1,
                'created_at' => $admin->created_at ?? now(),
                'updated_at' => $admin->updated_at ?? now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove migrated admin users
        DB::table('users')->where('role', 'admin')->delete();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('photo');
        });
    }
};
