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

    public function grupos()
    {
        return $this->hasMany('App\Grupo');
    }

    public function eventos()
    {
        return $this->hasMany('App\Evento');
    }
    
}
