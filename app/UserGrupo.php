<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGrupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_grupos';


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }

}
