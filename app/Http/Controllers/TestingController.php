<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Platform;
use App\Models\TagRetweet;
use App\Models\UserAccount;
use Thujohn\Twitter\Twitter;
use Abraham\TwitterOAuth\Request;
use App\Models\RetweetQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\SyncRepository;
use Illuminate\Support\Facades\Http;
use App\Repositories\UsersRepository;
use App\Repositories\TwitterRepository;

class TestingController extends Controller
{
    public function index()
    {
        $tweetsInQueue = RetweetQueue::where('completed', false)->first();
        $countTotalUsers =
            User::whereHas('roles', function ($role) {
                $role->where('name', 'User');
            })->withWhereHas('userAccounts', function ($query) {
                $query->where('platform_id', Platform::$TWITTER);
            })->take(20)->get()->pluck('userAccounts')
            ->flatten();


        if ($tweetsInQueue) {
            $TagRetweet = TagRetweet::where('post_id', $tweetsInQueue->post_id)->pluck('user_id');
            $users = User::whereHas('roles', function ($role) {
                $role->where('name', 'User');
            })->withWhereHas('userAccounts', function ($query) {
                $query->where('platform_id', Platform::$TWITTER);
            })->whereNotIn('id', $TagRetweet)->take(20)->get()->pluck('userAccounts')
                ->flatten();

            $totalUsersToRetweet = count($countTotalUsers);
            $retweetedUsers = count($TagRetweet);
            $remaining = $totalUsersToRetweet - $retweetedUsers;


            foreach ($users as $user) {
                // Replace these values with your actual Twitter API credentials

                $consumerKey = env('TWITTER_CLIENT_ID');
                $consumerSecret = env('TWITTER_CLIENT_SECRET');
                $accessToken = $user->access_token;
                $accessTokenSecret = $user->token_secret;

                // Twitter API endpoint
                $url = "https://api.twitter.com/2/users/" . $user->username . "/retweets";

                try {
                    // OAuth parameters
                    $oauth = [
                        'oauth_consumer_key' => $consumerKey,
                        'oauth_nonce' => uniqid(),
                        'oauth_signature_method' => 'HMAC-SHA1',
                        'oauth_timestamp' => time(),
                        'oauth_token' => $accessToken,
                        'oauth_version' => '1.0',
                    ];

                    // Generate the base string
                    $baseString = 'POST&' . rawurlencode($url) . '&' . rawurlencode(http_build_query($oauth));

                    // Generate the signing key
                    $signingKey = rawurlencode($consumerSecret) . '&' . rawurlencode($accessTokenSecret);

                    // Generate the signature
                    $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));

                    // Construct the Authorization header
                    $authHeader = 'OAuth ' . implode(', ', array_map(function ($v, $k) {
                        return sprintf('%s="%s"', $k, rawurlencode($v));
                    }, $oauth, array_keys($oauth)));

                    $client = new Client();

                    $response = $client->post($url, [
                        'headers' => [
                            'Authorization' => $authHeader,
                            'Content-Type' => 'application/json',
                        ],
                        'json' => [
                            'tweet_id' => $tweetsInQueue->tweet_id,
                        ],
                    ]);

                    $responseData = json_decode($response->getBody());
                    TagRetweet::updateOrCreate(
                        ['post_id' => $tweetsInQueue->post_id, 'user_id' => $user->user_id],
                        ['post_id' => $tweetsInQueue->post_id, 'user_id' => $user->user_id]
                    );
                } catch (\Throwable $th) {
                    continue;
                }
            }

            if ($remaining == 0) {
                $tweetsInQueue->completed = true;
                $tweetsInQueue->save();
            }
        }
    }
}
