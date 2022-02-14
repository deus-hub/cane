<?php

namespace Database\Seeders;

use App\Models\PercentageWithdrawal;
use Illuminate\Database\Seeder;

class PercentageWithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'key'      => '1',
                'value'      => '100'
            ],
            [
                'key'      => '2',
                'value'      => '75'
            ],
            [
                'key'      => '3',
                'value'      => '50'
            ],
            [
                'key'      => '4',
                'value'      => '25'
            ],
            [
                'key'      => '5',
                'value'      => '0'
            ]
        ];

        foreach ($datas as $data) {
            PercentageWithdrawal::create($data);
        }
    }
}
