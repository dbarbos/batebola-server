<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Config;

class Event extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';
    protected $fillable = ['group_id', 'name', 'date', 'local'];

    public function getDateAttribute($value) {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(Config::get('app.timezone'))->format('Y-m-d H:i:sP');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_events', 'event_id', 'user_id')->withPivot('paid');
    }

}
