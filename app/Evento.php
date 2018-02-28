<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eventos';


    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_eventos', 'evento_id', 'user_id')->withPivot('pagou');
    }

}
