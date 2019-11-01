<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255)->nullable();
            $table->string('cargo', 50)->nullable();
            $table->string('cpf', 11)->nullable();
            $table->date('data_admissao')->nullable();
            $table->string('genero', 10)->nullable();

            $table->string('cep', 50)->nullable();
            $table->string('logradouro', 50)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('uf', 50)->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('bairro', 50)->nullable();

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
        Schema::dropIfExists('funcionarios');
    }
}
