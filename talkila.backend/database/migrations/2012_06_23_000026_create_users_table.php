<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(1);
            $table->smallInteger('state')->unsigned()->default(1);
            $table->smallInteger('visibility')->unsigned()->default(1);
            $table->boolean('approved')->default(0)->nullable();
            $table->boolean('verified')->default(0)->nullable();
            $table->integer('billing_address_id')->default(1)->nullable();
            $table->smallInteger('gender')->default(1);
            $table->string('email', 50)->unique();
            $table->string('name', 50)->nullable();
            $table->string('username', 100)->nullable()->unique();
            $table->string('user_stripe_id', 255)->nullable();
            $table->string('user_stripe_account_id', 255)->nullable();
            $table->longText('description')->nullable();
            $table->string('profession', 50)->nullable();
            $table->string('password')->nullable();
            $table->string('password_tmp', 32)->nullable();
            $table->tinyInteger('password_salt')->nullable();
            $table->string('youtube_video', 100)->nullable();
            $table->string('email_activation_id', 45)->nullable();
            $table->boolean('notification_message')->nullable();
            $table->boolean('notification_sound')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->tinyInteger('login_type')->default(1)->nullable();
            $table->text('google_token')->nullable();
            $table->text('facebook_token')->nullable();
            $table->text('apple_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('verification_token')->nullable();
            $table->text('deactivation_reason')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
