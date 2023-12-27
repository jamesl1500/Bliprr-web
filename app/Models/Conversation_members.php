<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation_members extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = ['conversation_member_uid', 'conversation_uid', 'user_uid', 'user_role'];
}
