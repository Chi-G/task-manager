<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $names = [
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
        return [
            'name' => $this->faker->unique()->randomElement($names),
        ];
    }
}
