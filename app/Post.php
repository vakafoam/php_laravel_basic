<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    // no dummy data any more
}