<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $tasks = [
            'Design Homepage Layout',
            'Develop Login Page',
            'Write Marketing Copy',
            'Configure Database Schema',
            'Test User Authentication',
            'Create Support Tickets',
            'Plan Product Launch Event',
            'Migrate Customer Data',
            'Conduct Training Session',
            'Update Payment Gateway',
            'Review Content Structure',
            'Optimize Website Speed',
            'Build Mobile Navigation',
            'Schedule Social Media Posts',
            'Integrate API Endpoints',
            'Document User Manual',
            'Test Mobile Responsiveness',
            'Analyze Sales Data',
            'Set Up Analytics Tracking',
            'Finalize Project Timeline'
        ];

        $projects = Project::all();
        foreach ($tasks as $index => $name) {
            Task::create([
                'name' => $name,
                'project_id' => $projects[$index % $projects->count()]->id,
                'priority' => rand(1, 3),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
