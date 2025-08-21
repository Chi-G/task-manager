<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
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
        return [
            'name' => $this->faker->unique()->randomElement($tasks),
            'priority' => $this->faker->numberBetween(1, 3),
            // 'project_id' => Project::factory(), // Use seeder to assign project_id
        ];
    }
}
