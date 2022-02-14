<?php

namespace Database\Seeders;

use App\Models\InvestmentObjective;
use Illuminate\Database\Seeder;

class InvestmentObjectiveSeeder extends Seeder
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
                'value'      => 'preserve initial investment'
            ],
            [
                'key'      => '2',
                'value'      => 'income'
            ],
            [
                'key'      => '3',
                'value'      => 'income and growth'
            ],
            [
                'key'      => '4',
                'value'      => 'growth'
            ],
            [
                'key'      => '5',
                'value'      => 'aggressive growth'
            ]
        ];

        foreach ($datas as $data) {
            InvestmentObjective::create($data);
        }
    }
}
