<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_messages', function (Blueprint $table) {
            $table->id();
            $table->string('conversation_message_uid');
            $table->unsignedBigInteger('conversation_uid');
            $table->unsignedBigInteger('user_uid');
            
            // Foreign key constraints
            $table->foreign('conversation_uid')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('user_uid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->string('conversation_message_content');
            $table->string('conversation_message_type');
            $table->enum('conversation_message_status', ['read', 'unread', 'deleted']);
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
        Schema::dropIfExists('conversation_messages');
    }
}
