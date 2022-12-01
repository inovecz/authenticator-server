<?php

use App\Enums\GenderEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('surname', 64);
            $table->enum('gender', GenderEnum::values())->default(GenderEnum::OTHER->value);
            $table->string('hash', 32)->index();
            $table->string('email', 64)->unique();
            $table->string('phone', 16)->unique()->nullable()->comment('Phone in e-164 standard');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 60)->nullable();
            $table->timestamp('last_attempt_at')->nullable();
            $table->unsignedInteger('login_count')->default(0);
            $table->unsignedDouble('average_score')->default(0.0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
