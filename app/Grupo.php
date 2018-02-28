<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grupos';
    protected $fillable = ['nome','user_id'];

    public $timestamps = true;



    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function eventos()
    {
        return $this->hasMany('App\Evento');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_grupos', 'grupo_id', 'user_id')->withPivot('aprovado');
    }

    public function usersRequest()
    {
        return $this->users()->where('aprovado', '0')->get();
    }



}
