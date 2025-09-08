<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id' => 'admin1',
            'role' => 'admin',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Chạy seeders theo thứ tự: Professors trước, sau đó Departments để gán trưởng khoa
        $this->call([
            ProfessorSeeder::class,
            DepartmentSeeder::class,
        ]);
    }
}
