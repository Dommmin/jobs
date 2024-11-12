<?php

use App\Models\Offer;
use App\Models\Specialization;
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
        Schema::create('offer_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Offer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Specialization::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_specializations');
    }
};