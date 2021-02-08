<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workday extends Model
{
    Protected $fillable = ['day','active','morning_start','morning_end','afternoon_start','afternoon_end','user_id'];
}
