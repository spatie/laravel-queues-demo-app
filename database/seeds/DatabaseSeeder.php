<?php

use App\Models\Video;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 10)->create();
        factory(Video::class, 3)->create();

        factory(User::class)->create(['email' => 'freek@spatie.be', 'name' => 'Freek']);
    }
}
