<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $dates = ['birth_day' , 'join_day'];

    public function branches(){
        return $this->belongsTo('App\Models\Branchs','branch_id','id');
    }
    public function sports(){
        return $this->belongsTo('App\Models\Sports','sport_id','id');
    }

    public function players_files(){
        return$this->hasMany('App\Models\PlayersFiles','player_id','id');
    }
}
