<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\department;
use App\Models\professor;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentNames = [
            'Kỹ thuật máy tính',
            'IOT',
            'An ninh mạng',
            'Hệ thống thông tin',
            'Khoa học dữ liệu',
        ];

        $headProfessorIds = ['gv1', 'gv3', 'gv5', 'gv7', 'gv9'];

        foreach ($departmentNames as $index => $name) {
            $headProfessorId = $headProfessorIds[$index] ?? null;

            department::create([
                'name' => $name,
                'head_of_department_id' => $headProfessorId,
            ]);
        }
    }
}
