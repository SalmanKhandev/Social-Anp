<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\PostSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Console\Commands\PostsDeletion;
use GuzzleHttp\Exception\RequestException;


class TestingController extends Controller
{
    public function index(Request $request)
    {
        $user = Post::where('user_id', 26)->count();
        dd($user);
    }
}
