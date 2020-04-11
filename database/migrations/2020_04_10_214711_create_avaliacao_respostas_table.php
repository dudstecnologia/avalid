<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao_respostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resposta');
            $table->unsignedBigInteger('avaliacao_funcionario_id');
            $table->unsignedBigInteger('questao_id');
            $table->unsignedBigInteger('avaliador_id');
            $table->unsignedBigInteger('avaliado_id');
            $table->foreign('avaliacao_funcionario_id')->references('id')->on('avaliacaos');
            $table->foreign('questao_id')->references('id')->on('questaos');
            $table->foreign('avaliador_id')->references('id')->on('users');
            $table->foreign('avaliado_id')->references('id')->on('users');
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
        Schema::dropIfExists('avaliacao_respostas');
    }
}
