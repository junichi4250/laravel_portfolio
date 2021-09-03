<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    // ハッシュタグ表示
    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }

    public function portfolios(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Portfolio')->withTimestamps();
    }
}
