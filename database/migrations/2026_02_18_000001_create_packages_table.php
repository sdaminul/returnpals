<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('reference');
            $table->string('status')->default('In Transit');
            $table->text('notes')->nullable();
            $table->date('shipped_at')->nullable();
            $table->date('received_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'reference']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
