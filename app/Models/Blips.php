<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blips extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = ['buid', 'blip_author', 'blip_content', 'blip_privacy', 'blip_deleted'];
}
