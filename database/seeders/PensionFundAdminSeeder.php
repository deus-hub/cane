<?php

namespace Database\Seeders;

use App\Models\PensionFundAdmin;
use Illuminate\Database\Seeder;

class PensionFundAdminSeeder extends Seeder
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
                'name'      => 'AIICO Pension Managers Limited'
            ],
            [
                'name'      => 'APT Pension Fund Managers Limited'
            ],
            [
                'name'      => 'ARM Pension Managers Limited'
            ],
            [
                'name'      => 'AXA Mansard Pension Limited'
            ],
            [
                'name'      => 'CrusaderSterling Pensions Limited'
            ],
            [
                'name'      => 'Fidelity Pension Managers'
            ],
            [
                'name'      => 'First Guarantee Pension Limited'
            ],
            [
                'name'      => 'IEI-Anchor Pension Managers Limited'
            ],
            [
                'name'      => 'Investment One Pension Managers Limited'
            ],
            [
                'name'      => 'Leadway Pensure PFA Limited'
            ],
            [
                'name'      => 'Legacy Pension Managers Limited'
            ],
            [
                'name'      => 'NLPC Pension Fund Administrators Limited'
            ],
            [
                'name'      => 'NPF Pensions Limited'
            ],
            [
                'name'      => 'OAK Pensions Limited'
            ],
            [
                'name'      => 'Pensions Alliance Limited'
            ],
            [
                'name'      => 'Premium Pension Limited'
            ],
            [
                'name'      => 'Radix Pension Managers Limited'
            ],
            [
                'name'      => 'Stanbic IBTC Pension Managers Limited'
            ],
            [
                'name'      => 'Trustfund Pensions Plc'
            ],
            [
                'name'      => 'Veritas Glanvills Pensions Limited'
            ]
        ];

        foreach ($datas as $data) {
            PensionFundAdmin::create($data);
        }
    }
}
