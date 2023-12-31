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
        Schema::create('client_management', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->tinyInteger('status_id')->default(8);
            $table->longText('remarks')->nullable();
            $table->tinyInteger('deleted')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by',55)->nullable();
            $table->string('updated_by',55)->nullable();
            $table->string('deleted_by',55)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_management');
    }
};
