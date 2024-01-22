<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Platform;
use App\Models\TagRetweet;

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


    public function createRetweetTags($message, $post_id, $user_id)
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

            TagRetweet::updateOrCreate(
                ['user_id' => $user_id, 'tag_id' => $tags->id, 'post_id' => $post_id],
                ['user_id' => $user_id, 'tag_id' => $tags->id, 'post_id' => $post_id],
            );
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
            $query->where('platform_id', Platform::$TWITTER);
        })->orderBy('posts_count', 'Desc')->take(20)->get();
    }
}
