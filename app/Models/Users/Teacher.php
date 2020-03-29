<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['department_id','user_id','regalia_id'];
}
