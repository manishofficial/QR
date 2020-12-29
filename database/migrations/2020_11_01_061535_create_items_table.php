<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment('who created the item');
            $table->unsignedInteger('restaurant_id')->comment('item belongs to which restaurant');
            $table->unsignedInteger('category_id');
            $table->string('name');
            $table->text('details');
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->enum('discount_type',['flat','percent']);
            $table->enum('discount_to',['everyone','premium']);
            $table->string('image')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('items');
    }
}
