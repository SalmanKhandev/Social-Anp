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
        $startTime = $dateTime->format('Y-m-d') . 'T00:00:00Z';;
        $endTime = Carbon::now()->format('Y-m-d') . 'T00:00:00Z';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$bearerToken}",
        ])->get($baseURL, [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $data = $response->json();
        return $data;
    }
}
