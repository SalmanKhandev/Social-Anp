<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Setting;
use App\Models\Platform;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use App\Repositories\SyncRepository;
use App\Repositories\TwitterRepository;
use App\Repositories\HashTagsRepository;

class SyncTwitterController extends Controller
{
    public $syncTwitterRepository;
    public function __construct(SyncRepository $syncTwitterRepository)
    {
        $this->syncTwitterRepository = $syncTwitterRepository;
    }
    public function syncTwitterTweets()
    {
        try {
            $response = $this->syncTwitterRepository->syncTwitter();
            return response()->json(['success' => true, 'message' => $response->message]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage() . " at " . $th->getLine()]);
        }
    }

    public function runTwitterJobs()
    {
        try {
            $twitter = (new TwitterRepository)->runTwitterJobs();
            return (object) ['status' => true, 'message' => $twitter->message];
        } catch (\Throwable $th) {
            return (object) ['status' => false, 'message' => $th->getMessage()];
        }
    }
}
