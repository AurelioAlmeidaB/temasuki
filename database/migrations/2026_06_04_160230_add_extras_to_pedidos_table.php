<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('bebida_id')->nullable()->after('prato_id');
            $table->foreign('bebida_id')->references('id')->on('pratos')->onDelete('set null');
            $table->text('obs')->nullable()->after('quantidade');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['bebida_id']);
            $table->dropColumn(['bebida_id', 'obs']);
        });
    }
};
