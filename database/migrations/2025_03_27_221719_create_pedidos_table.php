<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->decimal('valor_total', 10, 2)->default(0.00);
            $table->enum('status', [1, 2, 3])
                ->default(1)
                ->comment('1 - Pendente, 2 - Pronto, 3 - Entregue');
            $table->timestamp('data_pedido')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
