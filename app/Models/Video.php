<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    protected $primaryKey = 'v_id';
    protected $fillable = [
        'ep_id',
        'v_path',
        'v_resolution'
    ];

    public function episode(): BelongsTo {
        return $this->belongsTo(Episode::class, 'ep_id');
    }
}
