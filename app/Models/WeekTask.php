<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekTask extends Model
{
    protected $fillable = [
        'week_id',
        'subject_id',
        'title',
        'content',
        'filenames',
        'status',
    ];

}
