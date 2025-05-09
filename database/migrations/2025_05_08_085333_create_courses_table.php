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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->longText('description');
            $table->text('preview')->nullable();
            $table->text('preview_image')->nullable();
            $table->decimal('price')->default(0);
            $table->enum('course_type',['free','paid'])->default('free');
            $table->text('duration')->nullable();

            // build a relation with category table
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // build a relation with user table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
