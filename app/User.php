<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Danjdewhurst\PassportFacebookLogin\FacebookLoginTrait;

class User extends Authenticatable 
{
    use Notifiable;
    use FacebookLoginTrait;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar','facebook_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getDates() {
        return ['created_at', 'updated_at'];
    }

    public function getImgAttribute() {
        return (\File::exists($this->_path . $this->avatar) && !empty($this->avatar)) ? url($this->_path . $this->avatar) : url("images/no-photo.jpg");
    }

    // Não sei porque, mas funciona!! (isso muda a autenticacao de email pra username na api)! 
    public function findForPassport($username) {  
        return $this->where('username', $username)->first();
    }

    public function my_groups()
    {
        return $this->hasMany('App\Group');
    }

    public function groups_joined()
    {
        return $this
            ->hasManyThrough('App\Group','App\UserGroup', 'user_id', 'id', 'id', 'group_id');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function badges() {
        return $this->hasMany('App\UserBadge','player_id');
    }

    public function badges_given() {
        return $this->hasMany('App\UserBadge','avaliator_id');
    }

    public function avaliations() {
        return $this->hasMany('App\Avaliation','player_id');
    }

    public function avaliations_given() {
        return $this->hasMany('App\Avaliation','avaliator_id');
    }
    
}
