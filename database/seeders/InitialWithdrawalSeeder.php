<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InitialWithdrawal;

class InitialWithdrawalSeeder extends Seeder
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
                'value'      => 'less than one year'
            ],
            [
                'key'      => '2',
                'value'      => 'between one and three years'
            ],
            [
                'key'      => '3',
                'value'      => 'between four and six years'
            ],
            [
                'key'      => '4',
                'value'      => 'between seven and ten years'
            ],
            [
                'key'      => '5',
                'value'      => 'over ten years'
            ]
        ];

        foreach ($datas as $data) {
            InitialWithdrawal::create($data);
        }
    }
}
