<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
     
    protected $fillable = [ 'name','description'];


    // $specialty->users

    public function users(){

        return $this->belongsToMany(user::class)->withTimesTamps();
    }
}
