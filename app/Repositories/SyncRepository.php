<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Platform;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class SyncRepository
{
    public function syncFacebook()
    {
        $allUsers = UserAccount::where('platform_id', Platform::$FACEBOOK)->get();
        foreach ($allUsers as $user) {
            $userPosts = $this->getUserFacebooksPosts($user->username, $user->access_token);
            foreach ($userPosts['data'] as $userPost) {
                $post = Post::updateOrCreate([
                    'post_id' => $userPost['id'],
                    'user_id' => $user->user_id,
                    'user_account_id' => $user->id,
                ], [
                    'content' => json_encode($userPost)
                ]);
                if (array_key_exists('message', $userPost)) {
                    (new HashTagsRepository)->createHashTags($userPost['message'], $post->id);
                }
            }
        }

        Setting::create(['sync_date' => Carbon::now()]);
    }

    public function syncTwitter()
    {
        try {
            $allUsers = UserAccount::with('user')->where('platform_id', Platform::$TWITTER)->get();
            foreach ($allUsers as $user) {
                // $userPosts = (new TwitterRepository)->getTweetsToday($user->username, $user->user->created_at);
                $userPosts = (new TwitterRepository)->retrieveUserTweets($user->username, $user->user->created_at);

                if (isset($userPosts['data'])) {
                    foreach ($userPosts['data'] as $userPost) {
                        $post = Post::updateOrCreate([
                            'post_id' => $userPost['id'],
                            'user_id' => $user->user_id,
                            'user_account_id' => $user->id,
                        ], [
                            'content' => json_encode($userPost)
                        ]);
                        if (array_key_exists('text', $userPost)) {
                            (new HashTagsRepository)->createHashTags($userPost['text'], $post->id);
                        }
                    }
                }
            }
            Setting::create(['sync_date' => Carbon::now()]);
            return (object) ['status' => true, 'message' => 'Tweets retrieved Succesffully'];
        } catch (\Throwable $th) {
            return (object) ['status' => false, 'message' => $th->getMessage()];
        }
    }



    public function getUserFacebooksPosts($userId, $accessToken)
    {
        try {
            $posts = $this->fetchUserPosts($userId, $accessToken);
            return $posts;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function fetchUserPosts($userId, $accessToken, $url = null, $posts = [])
    {
        $url = $url ? $url : $this->buildGraphUrlUrl($userId, $accessToken);
        $response = Http::get($url);
        if (isset($response['data']) && !empty($response['data'])) {
            $posts = [...$posts, ...$response['data']];
        }

        if (isset($response['paging']['next'])) {
            $newUrl = $response['paging']['next'];
            $posts =  $this->fetchUserPosts($userId, $accessToken, $newUrl, $posts);
        }
        return $posts;
    }


    public function buildGraphUrlUrl($userId, $accessToken)
    {
        // return "https://graph.facebook.com/v12.0/{$userId}/posts?access_token={$accessToken}";
        return  "https://graph.facebook.com/v12.0/{$userId}/posts?access_token=" . urlencode($accessToken);
    }
}
