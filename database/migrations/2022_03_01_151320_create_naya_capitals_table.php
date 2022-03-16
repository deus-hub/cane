<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNayaCapitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naya_capitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('exchange');
            $table->string('genericPassThruParam');
            $table->string('refCode');
            $table->string('kycRefNo');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('gender');
            $table->string('dob');
            $table->string('email');
            $table->string('phone');
            $table->string('mothersMaidenname')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postcode');
            $table->string('nationality');
            $table->string('stateOfOrigin');
            $table->string('lgaOfOrigin');
            $table->string('chn')->nullable();
            $table->string('nextOfKinName');
            $table->string('nextOfKinRelationship')->nullable();
            $table->string('nextOfKinAddress')->nullable();
            $table->string('nextOfKinPhone');
            $table->string('nextOfKinCHN')->nullable();
            $table->string('bank');
            $table->string('bankAccountName');
            $table->string('bankAccountNumber');
            $table->string('dateAccountOpened');
            $table->string('bvn');
            $table->string('currency')->nullable();
            $table->string('kycTier')->nullable();
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
        Schema::dropIfExists('naya_capitals');
    }
}
