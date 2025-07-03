<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Developer::factory(4)->has(Skill::factory(3))->create();
        Developer::factory(2)->create();
        Developer::factory()->has(Skill::factory(4))->create(['name' => 'Lívia']);
    }
}
