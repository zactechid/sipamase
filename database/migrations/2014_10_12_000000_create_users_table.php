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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('harmonisasi_id')->constrained('harmonisasi')->nullable();
            $table->unsignedBigInteger('rancangan_id')->constrained('rancangan');
            $table->unsignedBigInteger('pemrakarsa_id')->constrained('pemrakarsa');
            $table->unsignedBigInteger('role_id')->constrained('role');
            $table->unsignedBigInteger('tahun_id')->constrained('tahun');
            $table->string('username', 20)->unique();
            $table->string('password');
            $table->string('namaPanjang', 70)->unique();
            $table->string('alamat', 80)->default('Sulawesi Selatan');
            $table->string('email', 50)->unique();
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
