<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEvento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_eventos';


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function evento()
    {
        return $this->belongsTo('App\Evento');
    }

}
