<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostsRepository;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Repositories\TwitterRepository;
use App\Repositories\UsersRepository;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller
{
    public $twitterRepository;
    public $postsRepository;
    public $usersRepository;
    public function __construct(TwitterRepository $twitterRepository, PostsRepository $postsRepository, UsersRepository $usersRepository)
    {
        $this->twitterRepository = $twitterRepository;
        $this->postsRepository = $postsRepository;
        $this->usersRepository = $usersRepository;
    }

    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback()
    {
        $user = Socialite::driver('twitter')->user();
        $createUser = User::updateOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar
            ]
        );
        $createUser->assignRole('User');
        $userAccounts = UserAccount::updateOrCreate(
            ['username' => $user->id],
            [
                'user_id' => $createUser->id,
                'platform_id' => 2,
                'access_token' => $user->token,
            ]
        );

        $userTweets = $this->twitterRepository->getTweetsToday($user->id);
        if (isset($userTweets['data'])) {
            foreach ($userTweets['data'] as $userPost) {
                $post = Post::updateOrCreate([
                    'post_id' => $userPost['id'],
                    'user_id' => $createUser->id,
                    'user_account_id' => $userAccounts->id,
                ], [
                    'content' => json_encode($userPost)
                ]);
            }
            // return response()->json(['success' => true, 'message' => 'Users Tweets Saved Successfully']);
        }

        if (!$createUser->password) {
            session(['user' => $createUser]);
            return redirect()->route('user.register.form');
        }

        if ($createUser->status == 0) {
            return redirect()->route('login')->with('message', 'Your Account is not approved yet Please wait!');
        }

        Auth::loginUsingId($createUser->id);
        $findUser = $this->usersRepository->findUserById(auth()->user()->id);
        $findUser->twitter_connected = true;
        $findUser->save();
        session()->forget('user');
        return redirect()->route('users.dashboard')->with('message', 'Your Twitter is Connected!');
    }

    public function getUserTweets()
    {
        // $tweets = $this->twitterRepository->getTweetsToday('315765559');
        // foreach ($tweets['data'] as $userTweet) {
        //     $post = Post::updateOrCreate([
        //         'post_id' => $userTweet['id'],
        //         'user_id' => $createUser->id,
        //         'user_account_id' => $userAccounts->id,
        //     ], [
        //         'content' => json_encode($userPost)
        //     ]);
        //     if (array_key_exists('message', $userPost)) {
        //         $this->tagsRepository->createHashTags($userPost['message'], $post->id);
        //     }
        // }
    }

    public function userTwitterTweets()
    {
        $twitterTweets = $this->postsRepository->getPostAndTweets('Twitter');
        return view('users.twitter_tweets', ['groupedPosts' => $twitterTweets]);
    }
}
