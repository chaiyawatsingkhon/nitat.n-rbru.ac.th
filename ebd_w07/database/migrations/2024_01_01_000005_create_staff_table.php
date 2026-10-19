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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('fname', length: 200);
            $table->string('lname', length: 200);
            $table->unsignedBigInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organization');
            $table->unsignedBigInteger('tit_id');
            $table->foreign('tit_id')->references('id')->on('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
