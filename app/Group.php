<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groups';
    protected $fillable = ['name','user_id'];

    public $timestamps = true;

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_groups', 'group_id', 'user_id')->withPivot('approved');
    }

    public function users_request()
    {
        return $this->users()->where('approved', '0')->get();
    }

    public function users_approved()
    {
        return $this->users()->where('approved', '1')->get();
    }

}
