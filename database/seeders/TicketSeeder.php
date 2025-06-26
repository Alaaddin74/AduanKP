<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $categories = ['konten_tidak_pantas', 'menghapus_index', 'lainnya'];
        $priorities = ['low', 'medium', 'high'];
        $statuses = ['submitted', 'in_progress', 'done', 'rejected'];

        for ($i = 0; $i < 30; $i++) {
            $status = $faker->randomElement($statuses);
            $resolvedAt = in_array($status, ['done', 'rejected']) ? now()->subDays(rand(1, 10)) : null;

            Ticket::create([
                'ticket_number' => 'TCK-' . strtoupper(Str::random(6)),
                'user_id' => User::inRandomOrder()->value('id'),
                'category' => $faker->randomElement($categories),
                'priority' => $faker->randomElement($priorities),
                'site_link' => $faker->optional()->url,
                'faculty_id' => Faculty::inRandomOrder()->value('id'),
                'attachment' => $faker->optional()->imageUrl(),
                'status' => $status,
                'description' => $faker->paragraph,
                'resolved_at' => $resolvedAt,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}
