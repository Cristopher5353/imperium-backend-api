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
        Schema::create('documents_incidents_responses', function (Blueprint $table) {
            $table->increments("id");
            $table->string("document");
            $table->integer("incidence_response_id")->unsigned();
            $table->timestamps();

            $table->foreign("incidence_response_id")->references("id")->on("incidents_responses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_incidents_responses');
    }
};
