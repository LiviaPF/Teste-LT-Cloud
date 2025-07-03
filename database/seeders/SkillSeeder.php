<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::factory()->has(Developer::factory(5))->count(3)->create();
        Skill::factory()->create(['name' => 'PHP']);
        Skill::factory()->create(['name' => 'JavaScript']);
        Skill::factory()->create(['name' => 'Laravel']);
        Skill::factory()->create(['name' => 'React']);
        Skill::factory()->create(['name' => 'Python']);
    }
}
