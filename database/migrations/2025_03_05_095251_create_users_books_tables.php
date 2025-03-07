<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersBooksTables extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('reset_token', 64)->nullable();
            $table->enum('role', ['teacher', 'student'])->default('student');
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('isbn', 20)->unique();
            $table->string('author', 100);
            $table->timestamps();
        });

        Schema::create('user_books', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            
            $table->primary(['user_id', 'book_id']);
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_books');
        Schema::dropIfExists('books');
        Schema::dropIfExists('users');
    }
}