<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SyncRepository;
use App\Repositories\TwitterRepository;

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
            $this->syncTwitterRepository->syncTwitter();
            return response()->json(['success' => true, 'message' => 'Twitter Tweets Sync  successfully']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage() . " at " . $th->getLine()]);
        }
    }
}
