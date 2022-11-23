<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public static function up(): void
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('code', 10);
            $table->dateTime('valid_until');
            $table->timestamps();
        });
    }

    public static function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
