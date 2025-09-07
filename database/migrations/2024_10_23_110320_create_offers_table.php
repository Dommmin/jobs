<?php

use App\Models\User;
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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'company_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->string('slug', 120);
            $table->integer('salary_from')->nullable();
            $table->integer('salary_to')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('tech_stack');
            $table->dateTime('expire_at');
            $table->softDeletes();
            $table->timestamps();

//            $table->fullText('description');
            $table->index('title');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
