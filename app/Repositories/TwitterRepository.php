<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Setting;
use App\Models\Platform;
use App\Models\TagRetweet;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Http;

class TwitterRepository
{
    public function getTweetsToday($userId, $created_at)
    {

        $baseURL = "https://api.twitter.com/2/users/{$userId}/tweets";
        $bearerToken = env('BEARER_TOKEN');
        // $startTime = Carbon::today()->format('Y-m-d') . 'T00:00:00Z';
        $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);
        $startTime = $dateTime->format('Y-m-d') . 'T00:00:00Z';
        $endTime = Carbon::tomorrow()->format('Y-m-d') . 'T00:00:00Z';

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$bearerToken}",
        ])->get($baseURL, [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $data = $response->json();
        return $data;
    }



    public function retrieveUserTweets($userId, $date)
    {
        try {
            $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $date);
            $startTime = $dateTime->format('Y-m-d') . 'T00:00:00Z';
            $endTime = Carbon::tomorrow()->format('Y-m-d') . 'T00:00:00Z';
            $queryParams = [
                'max_results' => 100,
                'start_time' => $startTime,
                'end_time' => $endTime,
                // 'sort_by' => 'updated_at-desc',
            ];
            $allTweets = $this->fetchUserTweets($userId, $queryParams);
            return ['data' => $allTweets];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        // return response()->json(['tweets' => $allTweets, 'count' => count($allTweets)]);
    }

    private function fetchUserTweets($userId, $queryParams, $tweets = [])
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

    public function twitterTrends($request)
    {
        $tags = Tag::with(['posts.user'])->withCount('posts')->whereHas('posts.userAccount', function ($query) {
            $query->where('platform_id', Platform::$TWITTER);
        })->whereHas('posts')->when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        })->when(!empty($request->from_date) && empty($request->to_date), function ($query) use ($request) {
            $query->where('created_at', ">=", $request->from_date);
        })->when(empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->where('created_at', "<=", $request->to_date);
        })->orderBy('posts_count', 'desc')->get();

        $tagData = $tags->map(function ($tag) {
            $users = $tag->posts->groupBy('user_id')->map(function ($posts) {
                return [
                    'user' => $posts->first()->user->name,
                    'posts_count' => $posts->count(),
                ];
            })->sortByDesc('posts_count')->values()->all();

            return [
                'tag' => $tag->name,
                'users' => array_values($users), // Re-index the array numerically
                'posts_count' => $tag->posts->count(),
                'tweets_count' => $tag->posts->first()->retweets->count(),
                'retweets_count' => $tag->posts->first()->retweets->count()

            ];
        });

        return $tagData;
    }

    public function runTwitterJobs($limit = 10)
    {
        try {
            $allUsers = User::where('api_called', 0)
                ->whereHas('userAccounts', function ($query) {
                    $query->where('platform_id', Platform::$TWITTER);
                })
                ->take($limit)
                ->get()
                ->pluck('userAccounts')
                ->flatten();;
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
                        $this->updateApiStatus($user->user_id);
                    }
                }
            }
            Setting::create(['sync_date' => Carbon::now()]);
            return (object) ['status' => true, 'message' => 'Tweets retrieved Succesffully'];
        } catch (\Throwable $th) {
            return (object) ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function updateApiStatus($userId)
    {
        return  User::where('id', $userId)->update(['api_called' => true]);
    }



    public function syncTwitterRetweet($ids)
    {
        try {
            $allUsers = UserAccount::whereIn('user_id', $ids)->with('user')->where('platform_id', Platform::$TWITTER)->get();
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


    public function filterTwitterTrends($request)
    {
        $query = User::query();
        $fromDate = $request->from_date;
        $endDate = $request->end_date;
        $tagId = $request->tag_id;

        $query->when(!empty($request->tag_id), function ($query) use ($tagId) {
            $query->whereHas('posts.tags', function ($query) use ($tagId) {
                $query->where('id', $tagId);
            });
        })
            ->when(!empty($request->from_date), function ($query) use ($fromDate) {
                $query->whereHas('posts', function ($query) use ($fromDate) {
                    $query->whereDate('created_at', '>=', $fromDate);
                });
            })
            ->when(!empty($request->end_date), function ($query) use ($endDate) {
                $query->whereHas('posts', function ($query) use ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                });
            });

        $users = $query->withCount([
            'posts' => function ($query) use ($tagId) {
                if (isset($tagId)) {
                    $query->whereHas('tags', function ($query) use ($tagId) {
                        $query->where('id', $tagId);
                    });
                }
            }
        ])->withCount('retweets')->having('posts_count', '>', 0)->get();

        return $users;
    }

    public function retweets()
    {
        $leadersTweets = User::whereHas('roles', function ($query) {
            $query->where('name', 'Leader');
        })->with('posts')->get()->pluck('posts')->flatten();

        foreach ($leadersTweets as $tweet) {

            $users = UserAccount::where('platform_id', Platform::$TWITTER)->get();

            foreach ($users as $user) {
                // Replace these values with your actual Twitter API credentials

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
                            'tweet_id' => $tweet->post_id,
                        ],
                    ]);

                    $responseData = json_decode($response->getBody());
                    if (count($tweet->tags) > 0) {
                        foreach ($tweet->tags as $tag) {
                            TagRetweet::updateOrCreate([
                                'post_id' => $tweet->id,
                                'user_id' => $tweet->user_id,
                                'tag_id' => $tag->id
                            ]);
                        }
                    } else {
                        TagRetweet::updateOrCreate(
                            ['post_id' => $tweet->id, 'user_id' => $tweet->user_id],
                            ['post_id' => $tweet->id, 'user_id' => $tweet->user_id]
                        );
                    }
                } catch (\Throwable $th) {
                    if ($th->getCode() == 429) {
                        break;
                    }

                    continue;
                }
            }
        }
    }
}
