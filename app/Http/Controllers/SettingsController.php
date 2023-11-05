<?php

namespace App\Http\Controllers;

use App\Models\PostSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function setPostDeletionDate(Request $request)
    {
        $date = $request->date;
        $setDate = PostSetting::updateOrCreate(['id' => 1], ['post_deletion_date' => $date]);
        if ($setDate) {
            return response()->json(['status' => true, 'message' => 'Next Posts deletion Date Fixed successfully']);
        }
    }
}
