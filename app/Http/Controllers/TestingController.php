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
    public function index()
    {

        $users = User::withWhereHas('userAccounts', function ($query) {
            $query->where('platform_id', Platform::$FACEBOOK);
        })
            ->withCount(['userAccounts as user_facebook_accounts' => function ($query) {
                $query->where('platform_id', Platform::$FACEBOOK);
            }])
            ->withCount(['userAccounts as user_facebook_posts' => function ($query) {
                $query->where('platform_id', Platform::$FACEBOOK)->has('posts');
            }])
            ->having('user_facebook_posts', '>', 0)
            ->get();

        dd($users);


        $topUsers = User::withCount('posts')
            ->whereHas('userAccounts', function ($query) {
                $query->where('platform_id', 1);
            })
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->limit(10)
            ->get();

        return $topUsers;
    }
}
