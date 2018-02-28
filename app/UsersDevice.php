<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersDevice extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_device';
    protected $fillable = ['users_id','deviceToken','systemVersion','systemName','model','name'];
    

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the project record associated with the project.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

}
