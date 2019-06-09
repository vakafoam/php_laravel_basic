<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public function likes() 
    {
        return $this->hasMany('App\Like');
    }

    public function tags() 
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

     // Mutator function that transforms value automatically before storing to DB
    public function setTitleAttribute($value) // naming convention 
    {
        $this->attributes['title'] = strtolower($value); 
    }

    // Accessor funcion that transforms value automatically after read from DB
    public function getTitleAttribute($value) // naming convention
    {
        return strtoupper($value);
    }
}   