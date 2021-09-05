<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'introduction',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function portfolios(): HasMany
    {
        return $this->hasMany('App\Models\Portfolio');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'followed_id', 'following_id')->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'following_id', 'followed_id')->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Portfolio', 'likes')->withTimestamps();
    }

    // ユーザーをフォロー中かどうか判定
    public function isFollowedBy(?User $user): bool
    {
        return $user ? (bool) $this->followers->where('id', $user->id)->count() : false;
    }

    // フォロワー数
    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }

    // フォロー数
    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }

}
