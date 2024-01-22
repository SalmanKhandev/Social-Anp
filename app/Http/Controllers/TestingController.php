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
    }
}
