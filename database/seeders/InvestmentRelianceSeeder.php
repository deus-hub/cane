<?php

namespace Database\Seeders;

use App\Models\InvestmentReliance;
use Illuminate\Database\Seeder;

class InvestmentRelianceSeeder extends Seeder
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
                'value'      => 'heavily'
            ],
            [
                'key'      => '2',
                'value'      => 'moderately'
            ],
            [
                'key'      => '3',
                'value'      => 'slightly'
            ],
            [
                'key'      => '4',
                'value'      => 'not at all'
            ]
        ];

        foreach ($datas as $data) {
            InvestmentReliance::create($data);
        }
    }
}
