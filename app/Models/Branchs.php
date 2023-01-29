<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branchs extends Model
{

    use HasFactory;
    protected $guarded=[];

    public function sports() {

        return $this->belongsToMany('App\Models\Sports','branches_sports','sport_id','branch_id');
    }

}
