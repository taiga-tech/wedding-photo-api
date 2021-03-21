<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname',
        'message',
    ];

    public function photo()
    {
        return $this->hasMany('App\Models\PostPhoto');
    }
}
