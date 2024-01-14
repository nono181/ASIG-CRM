<?php

namespace Database\Seeders;

use App\Models\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => 1,
                'name'       => 'Lead',
                'created_at' => '2024-01-14 10:48:20',
                'updated_at' => '2024-01-14 10:48:20',
            ],
            [
                'id'         => 2,
                'name'       => 'Customer',
                'created_at' => '2024-01-14 10:48:20',
                'updated_at' => '2024-01-14 10:48:20',
            ],
            [
                'id'         => 3,
                'name'       => 'Partner',
                'created_at' => '2024-01-14 10:48:20',
                'updated_at' => '2024-01-14 10:48:20',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
