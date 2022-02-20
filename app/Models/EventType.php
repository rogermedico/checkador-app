<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    use HasFactory;

    public const IN = 1;
    public const OUT = 2;
    public const HOLIDAY = 3;
    public const PERSONAL_BUSINESS = 4;

    public $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
