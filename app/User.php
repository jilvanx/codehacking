<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'photo_id', 'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * User belongs to Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        // belongsTo(RelatedModel, foreignKey = role_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Role');
    }


    /**
     * User belongs to Photo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        // belongsTo(RelatedModel, foreignKey = photo_id, keyOnRelatedModel = id)
        return $this->belongsTo('App\Photo');
    }


    public function setPasswordAttribute($password){

        if(!empty($password)){

            $this->attributes['password'] = bcrypt($password);

        }

    }


    public function isAdmin(){

        if($this->role->name == "administrator" && $this->is_active == 1){

            return true;

        }

        return false;

    }


    public function posts(){

        return $this->hasMany('App\Post');

    }


    public function getGravatarAttribute(){

        $hash = md5(strtolower(trim($this->attributes['email'])));

        return "http://www.gravatar.com/avatar/$hash";

    }



}
