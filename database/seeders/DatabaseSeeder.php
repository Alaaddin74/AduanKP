<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $this->call(CategorySeeder::class);
        User::factory(10)->create();
        $this->call([
        FacultySeeder::class,
        TicketSeeder::class,
    ]);
    $this->call(CategorySeeder::class);


        User::factory()->create([
            'name' => 'Alaa',
            'email' => 'ala@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);
    }
}
