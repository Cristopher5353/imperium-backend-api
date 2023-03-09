<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->increments("id");
            $table->string("title");
            $table->integer("subcategory_id")->unsigned();
            $table->integer("priority_id")->unsigned();
            $table->text("description");
            $table->date("date_assignment")->nullable();
            $table->date("deadline")->nullable();
            $table->integer("user_id")->nullable()->unsigned();
            $table->timestamps();

            $table->foreign("subcategory_id")->references("id")->on("subcategories");
            $table->foreign("priority_id")->references("id")->on("priorities");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
};
