<?php

namespace App\Http\Controllers\facebook;

use App\Models\Post;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Repositories\PostsRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\HashTagsRepository;
use Laravel\Socialite\Facades\Socialite;


class FacebookController extends Controller
{
    private $postsRepository;
    public $sessionData;
    private $tagsRepository;
    public function __construct(PostsRepository $postsRepository, HashTagsRepository $tagsRepository)
    {
        $this->postsRepository = $postsRepository;
        $this->tagsRepository = $tagsRepository;
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->user();
        $profilePictureUrl = $this->getAvatar($user->token);

        // Fetch the user's profile picture using the Facebook Graph API
        $accessToken = "EAAD9Hh3uyzYBO99sjS62wZBCeofbRghOsQPU4sApvDCzNyct9rKZBr2KtZBQTYJWkAYGu6939Gv28oFcq2Q1TeTL68cNyVY4crZA2iLgdQyKZCR18GkVo06wOt2NOgW3r72z1Ga7gTpC9p9ZB3ac5shmp3vgnw4pFWsc4pNQ7vkGZBxl1NCZC46ZA49yBs99QJaoXqBCycR8adBo783PEeGMQMMPaQHcxRY9aSEjwZAzetJp3aia6z";
        $appSecret = config('services.facebook.client_secret'); // Get your Facebook app secret from config
        $appsecretProof = hash_hmac('sha256', $accessToken, $appSecret);

        $graphApiUrl = "https://graph.facebook.com/v12.0/me/picture?redirect=false&type=large&access_token={$accessToken}&appsecret_proof={$appsecretProof}";

        $response = Http::get($graphApiUrl);
        // $profilePictureUrl = $response->json()['data']['url'];
        $createUser = User::updateOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $profilePictureUrl
            ]
        );

        $createUser->assignRole('User');
        $userAccounts = UserAccount::updateOrCreate(
            ['username' => $user->id],
            [
                'user_id' => $createUser->id,
                'platform_id' => 1,
                'access_token' => $user->token,
            ]
        );
        $userPosts = $this->postsRepository->getUserPostFromGraph($user->token);
        foreach ($userPosts['data'] as $userPost) {
            $post = Post::updateOrCreate([
                'post_id' => $userPost['id'],
                'user_id' => $createUser->id,
                'user_account_id' => $userAccounts->id,
            ], [
                'content' => json_encode($userPost)
            ]);
            if (array_key_exists('message', $userPost)) {
                $this->tagsRepository->createHashTags($userPost['message'], $post->id);
            }
        }

        if (!$createUser->password) {
            session(['user' => $createUser]);
            return redirect()->route('user.register.form');
        }

        if ($createUser->status == 0) {
            return redirect()->route('login')->with('message', 'Your Account is not approved yet Please wait!');
        }

        Auth::loginUsingId($createUser->id);
        session()->forget('user');
        return redirect()->route('users.dashboard');
    }


    private function getUserPosts($accessToken)
    {
        try {
            // Make a GET request to get user posts
            $response = Http::get("https://graph.facebook.com/v13.0/me/posts", [
                'access_token' => $accessToken,
            ]);

            // Check if the request was successful (status code 200)
            if ($response->status() === 200) {
                // Decode the JSON response and return it
                return $response->json();
            } else {
                // Handle errors or return an empty array on failure
                // You can log the error or handle it as needed
                return [];
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., network errors) here
            // You can log the exception or handle it as needed
            return [];
        }
    }

    public function getAvatar($token)
    {
        // Make a request to Facebook Graph API to get the user's profile picture
        $response = Http::withToken($token)->get('https://graph.facebook.com/v13.0/me?fields=picture.type(large)');
        $data = $response->json();
        $profilePictureUrl = $data['picture']['data']['url'];
        return $profilePictureUrl;
    }

    public function checkEmailIfExists($email)
    {
        return User::where('email', $email)->first();
    }

    public function showPermission(Request $request)
    {
        dd(session('key'));
    }
}
