<?php

namespace Database\Seeders;

use Database\Seeders\ProjectSeeder;
use Database\Seeders\TaskSeeder;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
