<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    protected $primaryKey = "ss_id";
    use HasFactory;

    protected $fillable = [
        'ss_name',
        'sr_id',
        'ss_release_date',
        'ss_director',
        'ss_categories',
        'ss_description',
        'ss_tag',
        'ss_poster',
        'ss_bg',
        'ss_single'
    ];

    public function episodes(): HasMany {
        return $this->hasMany(Episode::class, 'ss_id');
    }

    public function seri(): BelongsTo {
        return $this->belongsTo(Serie::class, 'sr_id');
    }
}
