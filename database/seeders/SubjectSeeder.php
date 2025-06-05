<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            ['description' => 'Tecnologia'],
            ['description' => 'História'],
            ['description' => 'Matemática'],
            ['description' => 'Literatura'],
            ['description' => 'Filosofia'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
