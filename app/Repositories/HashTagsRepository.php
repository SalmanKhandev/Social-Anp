<?php

namespace App\Repositories;

use App\Models\Tag;

class HashTagsRepository
{
    public function createHashTags($message, $post_id)
    {
        $hashtags = [];
        preg_match_all('/#(\w+)/', $message, $matches);
        if (!empty($matches[0])) {
            $hashtags = $matches[0];
        }
        foreach ($hashtags as $hashtag) {
            $tags = Tag::updateOrCreate(
                ['name' => $hashtag],
                ['name' => $hashtag]
            );
            $tags->posts()->syncWithoutDetaching([$post_id]);
        }
    }

    public function all()
    {
        return Tag::all();
    }

    public function facebookTrendingPosts($limit = 5)
    {
        return Tag::withCount('posts')->orderBy('posts_count')->limit($limit)->get();
    }

    public function twitterTrendingTweets($limit = 5)
    {
        return Tag::withCount('posts')->whereHas('posts.userAccount', function ($query) {
            $query->where('platform_id', 2);
        })->orderBy('posts_count')->limit(10)->get();
    }
}
