<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class View extends Model
{
    use HasFactory;
    protected $primaryKey = 'view_id';
    protected $fillable = [
        'ep_id',
        'user_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function episode(): BelongsTo {
        return $this->belongsTo(Episode::class, 'ep_id');
    }
}
