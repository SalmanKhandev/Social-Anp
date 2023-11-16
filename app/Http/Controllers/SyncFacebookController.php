<?php

namespace App\Http\Controllers;

use App\Repositories\SyncRepository;
use Illuminate\Http\Request;

class SyncFacebookController extends Controller
{
    public $facebookSyncRepository;
    public function __construct(SyncRepository $facebookSyncRepository)
    {
        $this->facebookSyncRepository = $facebookSyncRepository;
    }
    public function syncFacebookPosts()
    {
        $syncFacebook = $this->facebookSyncRepository->syncFacebook();
        return response()->json(['success' => true, 'message' => 'Facebook Posts Sync  successfully']);
    }
}
