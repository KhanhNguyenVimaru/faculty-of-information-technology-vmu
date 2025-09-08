<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\professor;
use Illuminate\Support\Str;

class ProfessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 10 user với role professor và ID từ gv1 đến gv10
        for ($i = 1; $i <= 10; $i++) {
            $id = 'gv' . $i;
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $name = $firstName . ' ' . $lastName;
            $email = strtolower($firstName) . $id . '@st.vimaru.edu.vn';

            // Tạo hoặc cập nhật user
            $user = User::updateOrCreate(
                ['id' => $id],
                [
                    'role' => 'professor',
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'remember_token' => Str::random(10),
                ]
            );

            // Tạo professor tương ứng - không sử dụng timestamps vì bảng professors không có trường này
            professor::unguarded(function () use ($user) {
                $isHead = in_array($user->id, ['gv1','gv3','gv5','gv7','gv9']);
                $position = $isHead ? 'Trưởng khoa' : fake()->randomElement(['Giảng viên', 'Trợ giảng', 'Giáo sư', 'Phó giáo sư']);
                professor::updateOrCreate(
                    ['professor_id' => $user->id],
                    [
                        'position' => $position,
                        'birthdate' => fake()->dateTimeBetween('-60 years', '-30 years')->format('Y-m-d'),
                        'education_level' => fake()->randomElement(['Thạc sĩ', 'Tiến sĩ', 'Phó giáo sư', 'Giáo sư']),
                    ]
                );
            });
        }
    }
}
