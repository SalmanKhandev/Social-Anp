<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TwitterRepository
{
    public function getTweetsToday($userId)
    {
        $baseURL = "https://api.twitter.com/2/users/{$userId}/tweets";
        $bearerToken = env('BEARER_TOKEN');
        // $startTime = Carbon::today()->format('Y-m-d') . 'T00:00:00Z';
        $startTime = Carbon::now()->subDays(10)->format('Y-m-d') . 'T00:00:00Z';
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
}
