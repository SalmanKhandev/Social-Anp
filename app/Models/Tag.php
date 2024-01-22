<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_has_tags');
    }

    public function tagTweets()
    {
        return $this->hasMany(TagRetweet::class, 'tag_id', 'id');
    }
}
