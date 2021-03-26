<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Specialty extends Model
{
     
    protected $fillable = [ 'name','description'];


    // $specialty->users

    public function users(){

        return $this->belongsToMany(User::class)->withTimesTamps();
    }
}
