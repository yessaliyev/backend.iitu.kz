<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    const DEFAULT_WEEK = 1;
    const MIDTERM_WEEk = 2;
    const ENDTERM_WEEK = 3;

    protected $fillable = ['week_num', 'start', 'end', 'status', 'test'];

    public function getTasks()
    {
        return $this->hasOne('App\Models\WeekTask');
    }
}
