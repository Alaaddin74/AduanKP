<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faculties = [
            'MIPA',
            'FIK',
            'FEB',
            'FISIP',
            'FK',
            'Hukum',
            'Pascasarjana',
        ];

        foreach ($faculties as $name) {
            Faculty::create(['name' => $name]);
        }

    }
}
