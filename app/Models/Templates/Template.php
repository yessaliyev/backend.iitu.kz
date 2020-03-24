<?php

namespace App\Models\Templates;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['user_id','template','finger_id'];
}
