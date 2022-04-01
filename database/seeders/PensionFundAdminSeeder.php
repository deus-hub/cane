<?php

namespace Database\Seeders;

use App\Models\PensionFundAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PensionFundAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pension_fund_admins')->truncate();

        $datas = [
            [
                'name'      => 'AIICO Pension Managers Limited',
                'website'   => 'https://app.aiicopension.com'
            ],
            [
                'name'      => 'APT Pension Fund Managers Limited',
                'website'   => 'https://www.aptpensions.com'
            ],
            [
                'name'      => 'ARM Pension Managers Limited',
                'website'   => 'https://armpension.com/'
            ],
            [
                'name'      => 'AXA Mansard Pension Limited',
                'website'   => 'https://www.axamansard.com/'
            ],
            [
                'name'      => 'CrusaderSterling Pensions Limited',
                'website'   => 'https://crusaderpensions.com'
            ],
            [
                'name'      => 'Fidelity Pension Managers',
                'website'   => 'https://www.fidelitypensionmanagers.com'
            ],
            [
                'name'      => 'First Guarantee Pension Limited',
                'website'   => 'http://www.firstguaranteepension.com'
            ],
            [
                'name'      => 'IEI-Anchor Pension Managers Limited',
                'website'   => 'https://www.ieianchorpensions.com.ng'
            ],
            [
                'name'      => 'Investment One Pension Managers Limited',
                'website'   => 'https://www.stanbicibtcpension.com'
            ],
            [
                'name'      => 'Leadway Pensure PFA Limited',
                'website'   => 'https://leadway-pensure.com'
            ],
            [
                'name'      => 'Legacy Pension Managers Limited',
                'website'   => 'https://www.fcmb.com/legacy-pension-managers-limited-is-now-fcmb-pensions-limited'
            ],
            [
                'name'      => 'NLPC Pension Fund Administrators Limited',
                'website'   => 'https://www.nlpcpfa.com'
            ],
            [
                'name'      => 'NPF Pensions Limited',
                'website'   => 'https://www.npfpensions.com.ng'
            ],
            [
                'name'      => 'OAK Pensions Limited',
                'website'   => 'https://www.oakpensions.com'
            ],
            [
                'name'      => 'Pensions Alliance Limited',
                'website'   => 'not available'
            ],
            [
                'name'      => 'Premium Pension Limited',
                'website'   => 'https://www.palpensions.com'
            ],
            [
                'name'      => 'Radix Pension Managers Limited',
                'website'   => 'https://www.radixpension.com'
            ],
            [
                'name'      => 'Stanbic IBTC Pension Managers Limited',
                'website'   => 'https://tinyurl.com/y3aptcd8'
            ],
            [
                'name'      => 'Trustfund Pensions Plc',
                'website'   => 'https://trustfundpensions.com'
            ],
            [
                'name'      => 'Veritas Glanvills Pensions Limited',
                'website'   => 'https://vgpensions.com'
            ]
        ];

        foreach ($datas as $data) {
            PensionFundAdmin::create($data);
        }
    }
}
