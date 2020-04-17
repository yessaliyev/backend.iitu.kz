<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name_en',
        'name_ru',
        'name_kk',
        'o_id',
    ];

    public function groups(){
        return $this->belongsToMany('App\Models\Group','schedules');
    }
}
