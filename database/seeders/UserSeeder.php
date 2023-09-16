<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            1 => array('name' => 'Aris Flores', 'username' => 'aris', 'role_id' => 1),
            2 => array('name' => 'Almer Solis', 'username' => 'almer', 'role_id' => 1),
            3 => array('name' => 'Test User 1', 'username' => 'test1', 'role_id' => 1),
            3 => array('name' => 'Test User 2', 'username' => 'test2', 'role_id' => 1),
        ];

        foreach($users as $key => $user) {
            User::create([
                'uuid' => Str::uuid(),
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['username'] . '@test.com',
                'password' => Hash::make('12345678'),
                'role_id' => $user['role_id'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
