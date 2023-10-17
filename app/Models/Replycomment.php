<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Replycomment extends Model
{
    protected $primaryKey = "rcmt_id";
    use HasFactory;

    protected $fillable = [
        'cmt_id',
        'rcmt_content',
        'user_id',
        'rcmt_who'
    ];

    public function comment(): BelongsTo {
        return $this->belongsTo(Comment::class, 'cmt_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replyUser(): BelongsTo {
        return $this->belongsTo(User::class, 'rcmt_who', 'user_id');
    }
}
