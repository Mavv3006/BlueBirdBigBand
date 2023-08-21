<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'plz';

    protected $fillable = ['plz', 'name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function concerts(): HasMany
    {
        return $this->hasMany(Concert::class, 'venue_plz', 'plz');
    }
}
