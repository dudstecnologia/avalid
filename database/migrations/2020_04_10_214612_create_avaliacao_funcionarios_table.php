<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao_funcionarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('periodo');
            $table->unsignedBigInteger('avaliacao_id');
            $table->boolean('status')->default(true);
            $table->foreign('avaliacao_id')->references('id')->on('avaliacaos');
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
        Schema::dropIfExists('avaliacao_funcionarios');
    }
}
