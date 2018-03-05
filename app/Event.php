<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';
    protected $fillable = ['group_id', 'name', 'date', 'local'];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_events', 'event_id', 'user_id')->withPivot('paid');
    }

}
