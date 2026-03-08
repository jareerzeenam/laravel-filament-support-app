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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', \App\Enums\Feature\FeatureStatus::cases());
            $table->enum('type', \App\Enums\Feature\FeatureType::cases());
            $table->text('description');
//            $table->json('milestones')->nullable();
            $table->smallInteger('effort_in_days')->unsigned()->default(0);
            $table->smallInteger('priority')->unsigned()->default(0);
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->date('target_delivery_date')->nullable();
            $table->time('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
