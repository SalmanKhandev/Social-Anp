<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Setting;
use App\Models\UserAccount;

class SyncRepository
{
    public function syncFacebook()
    {
        $allUsers = UserAccount::all();
        foreach ($allUsers as $user) {
            $userPosts = (new PostsRepository)->getUserPostFromGraph($user->access_token);
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
}
