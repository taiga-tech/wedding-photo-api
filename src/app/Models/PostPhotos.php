<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPhotos extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
