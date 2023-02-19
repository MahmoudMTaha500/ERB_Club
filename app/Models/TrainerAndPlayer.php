<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerAndPlayer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stadiums()
    {
        return $this->belongsTo('App\Models\Stadium', 'stadium_id', 'id');
    }

    public function players()
    {
        return $this->hasMany('App\Models\eventTrainerPlayers', 'player_id', 'id');
    }
}
