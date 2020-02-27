<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('control_number');
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->string('unregistered_applicant')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->string('destination')->nullable();
            $table->string('purposes')->nullable();
            $table->longText('personnel')->nullable();
            $table->float('request_liters');
            $table->integer('weekly_trigger')->default('0');
            $table->decimal('UP',8,2);
            $table->unsignedBigInteger('dm_flag')->default('0');
            $table->unsignedBigInteger('gm_flag')->default('0');
            $table->unsignedBigInteger('gas_slip_flag')->default('0');
            $table->unsignedBigInteger('emergency')->default('0');
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
        Schema::dropIfExists('applications');
    }
}
