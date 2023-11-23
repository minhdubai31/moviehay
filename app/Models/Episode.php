<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;
    protected $primaryKey = "ep_id";
    protected $fillable = [
        'ep_name',
        'sr_id',
        'ss_id',
        'ep_order',
        'ep_thumbnail'
    ];

    public function season(): BelongsTo {
        return $this->belongsTo(Season::class, 'ss_id');
    }

    public function videos(): HasMany {
        return $this->hasMany(Video::class, 'ep_id');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'ep_id');
    }

    public function views(): HasMany {
        return $this->hasMany(View::class, 'ep_id');
    }

    public function likes(): HasMany {
        return $this->hasMany(Like::class, 'ep_id');
    }
}
