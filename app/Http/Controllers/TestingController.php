<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Platform;
use App\Models\PostSetting;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Repositories\SyncRepository;
use Illuminate\Support\Facades\Http;
use App\Console\Commands\PostsDeletion;
use App\Repositories\TwitterRepository;
use League\OAuth1\Client\Server\Twitter;
use GuzzleHttp\Exception\RequestException;

class TestingController extends Controller
{
    // public function index()
    // {
    //     $userId = '1067464793630613504';
    //     $queryParams = [
    //         'max_results' => 100
    //     ];

    //     $tweets = $this->retriveTweets($userId, $queryParams);
    //     dd($tweets);
    // }

    // public function retriveTweets($userId, $queryParams, $tweets = [])
    // {
    //     $response = $this->twitterUrl($userId, $queryParams);
    //     $data = $response->json();
    //     if (isset($data['data'])) {
    //         $tweets = array_merge($tweets, $data['data']);
    //     }

    //     if (isset($data['meta']['next_token'])) {
    //         $queryParams['pagination_token'] = $data['meta']['next_token'];
    //         return  $this->retriveTweets('1067464793630613504', $queryParams, $tweets);
    //     }

    //     return $tweets;
    // }

    // public function twitterUrl($userId, $queryParams)
    // {

    //     return Http::withToken(env('BEARER_TOKEN'))
    //         ->get("https://api.twitter.com/2/users/{$userId}/tweets", $queryParams);
    // }



    public function index()
    {
        $data = (new TwitterRepository)->retrieveUserTweets('1067464793630613504', '2023-12-29 01:06:12');
        return $data;
    }

    private function fetchUserTweets($userId, $queryParams, &$tweets = [])
    {
        $response = $this->getUserTweets($userId, $queryParams);
        $data = $response->json();

        if (isset($data['data'])) {
            $tweets = array_merge($tweets, $data['data']);
        }

        // Check if there are more tweets
        if (isset($data['meta']['next_token'])) {
            $nextToken = $data['meta']['next_token'];
            $queryParams['pagination_token'] = $nextToken;
            $tweets = $this->fetchUserTweets($userId, $queryParams, $tweets);
        }

        return $tweets;
    }

    private function getUserTweets($userId, $queryParams)
    {
        return Http::withToken(env('BEARER_TOKEN'))
            ->get("https://api.twitter.com/2/users/{$userId}/tweets", $queryParams);
    }
}
