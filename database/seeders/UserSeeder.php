<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(2)->create();
        $first_user = User::first();
        $first_user->email = 'teamadmin@example.com';
        $first_user->save();
    }
}
