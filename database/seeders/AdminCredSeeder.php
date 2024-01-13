<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminCredSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      User::create([
        'name' =>"Admin",
        'email' => "admin@admin.com",
        'password' => bcrypt('password'),
        'is_admin' =>1
      ]);
    }
}
