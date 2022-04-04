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
        Schema::create('retorno_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retorno_id');
            $table->unsignedBigInteger('recebimento_id');
            $table->string('operacao', 3);
            $table->unsignedFloat('valor_cobranca');
            $table->unsignedFloat('valor_pago');
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
        Schema::dropIfExists('retorno_items');
    }
};
