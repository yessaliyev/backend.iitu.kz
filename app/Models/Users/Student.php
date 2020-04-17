<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = ['user_id','group_id'];

    public function group(){
        return $this->hasOne('\App\Models\Group','id','group_id');
    }
}

