<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;

    // By default is true, but set it explicitly
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ROLE_ADMIN);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->where('name', $role)->isNotEmpty();
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles')->withTimestamps();
    }


    public function orders(): HasMany
    {
        // return $this->hasMany(Product::class)->latest();
        // We don't want the column on the Product's table to be called
        // user_id (the default) but author_id

        return $this->hasMany(Order::class, 'user_id');
    }


    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            // if ($model->roles()->count() == 0)
            //    $model->roles()->attach(Role::where('name', Role::ROLE_USER)->first());
        });

        self::updating(function ($model) {
            if ($model->roles()->count() == 0)
                $model->roles()->sync(Role::where('name', Role::ROLE_USER)->first());
        });
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $roles = [];
        for ($i = 0; $i < $this->roles->count(); $i++)
            $roles[] = $this->roles()->get()[0]->name;
        return [
            'user_id' => $this->id,
            'username' => $this->username,
            'roles' => $roles,
        ];
    }
}