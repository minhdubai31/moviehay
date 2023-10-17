<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serie extends Model
{
    protected $primaryKey = "sr_id";
    use HasFactory;

    protected $fillable = [
        'sr_name',
        'sr_country',
        'sr_poster'
    ];

    public function seasons(): HasMany {
        return $this->hasMany(Season::class, 'sr_id');
    }
}
