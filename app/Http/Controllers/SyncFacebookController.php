<?php

namespace App\Http\Controllers;

use App\Repositories\SyncRepository;
use Illuminate\Http\Request;

class SyncFacebookController extends Controller
{
    public $syncRepository;
    public function __construct(SyncRepository $syncRepository)
    {
        $this->syncRepository = $syncRepository;
    }
    public function syncFacebookPosts()
    {
        $syncFacebook = $this->syncRepository->syncFacebook();
        return response()->json(['success' => true, 'message' => 'Facebook Posts Sync  successfully']);
    }
}
