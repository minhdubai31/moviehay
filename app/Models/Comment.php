<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    protected $primaryKey = "cmt_id";
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ep_id',
        'cmt_content',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function episode(): BelongsTo {
        return $this->belongsTo(Episode::class, 'ep_id');
    }

    public function replycomments(): HasMany {
        return $this->hasMany(Replycomment::class, 'cmt_id');
    }
}
