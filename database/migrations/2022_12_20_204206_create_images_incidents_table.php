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
        Schema::create('images_incidents', function (Blueprint $table) {
            $table->increments("id");
            $table->string("image");
            $table->integer("incidence_id")->unsigned();
            $table->timestamps();

            $table->foreign("incidence_id")->references("id")->on("incidents");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_incidents');
    }
};
