<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $casts = [
        'content' => 'array',
    ];
    protected $guarded = [];


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_has_tags');
    }

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function retweets()
    {
        return $this->hasMany(TagRetweet::class, 'post_id', 'id');
    }
}
