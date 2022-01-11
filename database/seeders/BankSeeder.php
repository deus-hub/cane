<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
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
                'bank_code' => '044',
                'bank'      => 'Access Bank'
            ],
            [
                'bank_code' => '023',
                'bank'      => 'Citibank'
            ],
            [
                'bank_code' => '063',
                'bank'      => 'Access (Diamond) Bank'
            ],
            [
                'bank_code' => '050',
                'bank'      => 'Ecobank'
            ],
            [
                'bank_code' => '070',
                'bank'      => 'Fidelity Bank'
            ],
            [
                'bank_code' => '011',
                'bank'      => 'First Bank'
            ],
            [
                'bank_code' => '214',
                'bank'      => 'FCMB'
            ],
            [
                'bank_code' => '058',
                'bank'      => 'Guaranty Trust Bank'
            ],
            [
                'bank_code' => '030',
                'bank'      => 'Heritage Bank'
            ],
            [
                'bank_code' => '082',
                'bank'      => 'Keystone Bank'
            ],
            [
                'bank_code' => '301',
                'bank'      => 'Providus Bank'
            ],
            [
                'bank_code' => '076',
                'bank'      => 'Polaris (Skye) Bank'
            ],
            [
                'bank_code' => '221',
                'bank'      => 'Stanbic IBTC Bank'
            ],
            [
                'bank_code' => '068',
                'bank'      => 'Standard Chartered'
            ],
            [
                'bank_code' => '232',
                'bank'      => 'Sterling Bank'
            ],
            [
                'bank_code' => '302',
                'bank'      => 'Suntrust Bank'
            ],
            [
                'bank_code' => '032',
                'bank'      => 'Union Bank'
            ],
            [
                'bank_code' => '033',
                'bank'      => 'United Bank for Africa'
            ],
            [
                'bank_code' => '215',
                'bank'      => 'Unity Bank plc'
            ],
            [
                'bank_code' => '035',
                'bank'      => 'Wema Bank'
            ],
            [
                'bank_code' => '057',
                'bank'      => 'Zenith Bank'
            ],
            [
                'bank_code' => '303',
                'bank'      => 'Jaiz Bank'
            ]
        ];

        foreach ($datas as $data) {
            Bank::create($data);
        }
    }
}
