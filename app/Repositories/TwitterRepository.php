<?php

namespace App\Repositories;

use Carbon\Carbon;
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
            ];
            $userId = '1067464793630613504';

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
}
