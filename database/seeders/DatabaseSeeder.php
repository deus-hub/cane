<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(BankSeeder::class);
        $this->call(PensionFundAdminSeeder::class);
        // $this->call(DippReactionSeeder::class);
        // $this->call(InitialWithdrawalSeeder::class);
        // $this->call(InvestmentObjectiveSeeder::class);
        // $this->call(InvestmentQuestionnaireSeeder::class);
        // $this->call(InvestmentRelianceSeeder::class);
        // $this->call(PercentageWithdrawalSeeder::class);
    }
}
