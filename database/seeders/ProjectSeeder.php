<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            'Website Redesign 2025',
            'Mobile App Development',
            'Marketing Campaign Launch',
            'ERP System Implementation',
            'Customer Support Portal',
            'Product Launch Prep',
            'Data Migration Project',
            'Team Training Program',
            'E-commerce Platform Upgrade',
            'Content Management System'
        ];

        foreach ($projects as $name) {
            Project::create(['name' => $name, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
