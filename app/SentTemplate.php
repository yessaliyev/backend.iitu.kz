<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentTemplate extends Model
{
    protected $fillable = ['room_id','data'];
}
