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

class TestingController extends Controller
{
    public function index()
    {
        // $data =  (new SyncRepository)->getUserFacebooksPosts('1739169136524225', 'EAAD9Hh3uyzYBO3Ai9CaucsClu43rAWKVLdHfuCrHJkMTqLZBqQ0l4f3QNoXW6TR9p5lL2IRMx948qHE2ZB7tp1UHPb8JVT2JoZAuZC5sZB5KArBv0IPpOZBpZBXRLAG6gWvYrsiaADaOTZAQ3tgw4Y2ZA1ldaaZCZBhZA7pNWuOpjaoMJf31yU3ECrd3FjANEIOKQCx5F2Nk4rk92A3pFUUtcG2OOn4ZAd7LrexAA6NKnHZAGBmVMZB6A4b');
        // dd($data);

        try {
            $url = "https://graph.facebook.com/v12.0/1533946880754850/posts?access_token=" . urlencode("EAAD9Hh3uyzYBO3x8wHqezyAb4ANZAEbHHdmj6mz1RVQbVhT07k11N2M3S47mSXWZBBU09swQR4cOBiVoEZBjons6KvJxe1egVGhAVeZCBFyqAZBw0Hl0hhZAXvQD4P1LjU2AhfAEnyY7rfZBipFcsLMjWYicj9ixZCfZBKYSrZCikIoVFVELFBP0Ot3VJ5ju3SWiYUjnihRiAu1JqaTs86iASmb1o00piZBxSmw2Yh06DwJrnjWg0rb");
            $data = Http::get($url);
            $response = $data->json();
            dd($response);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
