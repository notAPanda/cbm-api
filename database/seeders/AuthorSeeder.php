<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Author;
use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::factory()
            ->count(10)
            ->has(
                Album::factory()->count(3)->has(
                    Track::factory()->count(10)
                )
            )
            ->create();
    }
}
