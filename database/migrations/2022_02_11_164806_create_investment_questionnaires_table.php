<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->integer('percentage_withdrawal');
            $table->integer('investment_objective');
            $table->integer('initial_withdrawal');
            $table->integer('investment_reliance');
            $table->integer('dipp_reaction');
            $table->string('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_questionnaires');
    }
}
