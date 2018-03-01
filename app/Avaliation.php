<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aavliation extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'avaliations';


    public function player()
    {
        return $this->hasOne('App\User','id','player_id');
    }

    public function avaliator()
    {
        return $this->hasOne('App\User','id','avaliator_id');
    }
}
