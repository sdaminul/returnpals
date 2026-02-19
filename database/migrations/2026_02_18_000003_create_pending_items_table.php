<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pending_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('reference');
            $table->string('product_name');
            $table->unsignedInteger('quantity')->default(1);
            $table->date('received_at')->nullable();
            $table->string('stage')->default('Initial Inspection');
            $table->date('est_completion')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'stage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_items');
    }
};
