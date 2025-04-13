<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('objectkey')->nullable()->after('bairro'); // adiciona a coluna "objectkey" depois de "bairro"
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('objectkey');
        });
    }
};
