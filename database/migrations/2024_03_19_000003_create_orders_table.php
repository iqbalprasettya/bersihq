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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('berat', 5, 2)->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['diterima', 'diproses', 'siap_diambil', 'selesai'])->default('diterima');
            $table->datetime('tanggal_pesan')->default(now());
            $table->datetime('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
