<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = User::factory(10)->create();


        $posts = Post::factory(20)->recycle($users)->create();


    }
}
