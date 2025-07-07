<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory(3)->has(Developer::factory(3))->create();
        Article::factory(2)->has(Developer::factory(4))->create();
        Article::factory(5)->has(Developer::factory(2))->create();
        Article::factory(7)->has(Developer::factory(1))->create();
    }
}
