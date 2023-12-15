<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\PostSetting;
use Illuminate\Http\Request;
use App\Repositories\SyncRepository;
use Illuminate\Support\Facades\Http;
use App\Console\Commands\PostsDeletion;
use App\Repositories\TwitterRepository;
use GuzzleHttp\Exception\RequestException;
use PhpParser\Node\Stmt\TryCatch;
use League\OAuth1\Client\Server\Twitter;

class TestingController extends Controller
{
    public function index()
    {
        $baseURL = "https://api.twitter.com/2/users/66178282/tweets";
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
        dd($data);
        return $data;
    }
}
