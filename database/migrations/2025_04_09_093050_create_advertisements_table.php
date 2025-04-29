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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->integer('duration_seconds');
            $table->decimal('reward_amount', 10, 2);
            $table->string('image')->nullable(); // Original image name
            $table->string('media_type')->default('image')->nullable(); // video/image
            $table->string('image_path')->nullable(); // Full image path
            $table->string('video_path')->nullable(); // Full video path
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Add this line
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
