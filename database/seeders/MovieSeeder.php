<?php

namespace Database\Seeders;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'title' => 'Inception',
            'description' => 'Dream within a dream',
            'release_year' => 2010
        ]);

        Movie::create([
            'title' => 'Interstellar',
            'description' => 'Space exploration',
            'release_year' => 2014
        ]);
    }
}
