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
        Schema::create('medicines', function (Blueprint $t) {
          $t->id();
          $t->string('name');
          $t->unsignedInteger('stock')->default(0);
          $t->decimal('price',12,2);
          $t->date('exp_date')->nullable();
          $t->string('image_path')->nullable();
          $t->foreignId('category_id')->constrained()->cascadeOnDelete();
          $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
