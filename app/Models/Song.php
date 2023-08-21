<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'file_path',
        'title',
        'author',
        'genre',
        'arranger',
        'size',
    ];
}
