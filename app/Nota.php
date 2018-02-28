<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notas';


    public function jogador()
    {
        return $this->hasOne('App\User','id','jogador_id');
    }
}
