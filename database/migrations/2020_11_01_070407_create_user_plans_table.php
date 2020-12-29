<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('plan_id');
            $table->dateTime('start_date');
            $table->dateTime('expired_date')->nullable();
            $table->enum('is_current',['yes','no'])->default('no');
            $table->string('payment_method')->nullable();
            $table->text('other_info')->nullable();
            $table->string('transaction_id')->nullable();
            $table->double('cost')->default('0');
            $table->enum('recurring_type',['onetime','monthly','weekly','yearly']);
            $table->integer('table_limit')->default(0);
            $table->integer('restaurant_limit')->default(0);
            $table->integer('item_limit')->default(0);
            $table->enum('status',['pending','approved','rejected'])->default('pending');
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
        Schema::dropIfExists('user_plans');
    }
}
