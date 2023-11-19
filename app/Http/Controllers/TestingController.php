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
        $posts = [];
        $reports = Post::query();
        $reports->with('tags', 'user', 'userAccount.platform');

        $tag = 124;
        $request = request();
        if (!empty($request->user_id)) {
            $reports->where('user_id', $request->user_id);
        }

        if (!empty($request->from_date)) {
            $reports->whereDate('created_at', '>=', $request->from_date);
        }

        if (!empty($request->end_date)) {
            $reports->whereDate('created_at', '<=', $request->end_date);
        }

        if (!empty($request->platform_id)) {
            $reports->whereHas('userAccount', function ($query) use ($request) {
                $query->where('platform_id', $request->platform_id);
            });
        }

        if (!empty($request->category)) {
            $reports->where('category', $request->category);
        }

        if (!empty($request->tag)) {
            $reports->whereHas('tags', function ($query) use ($request) {
                $query->where('id', $request->tag);
            });
        }


        $filter = $reports->get();


        foreach ($filter as $report) {
            $content = json_decode($report->content);
            $message = isset($content->message) ? $content->message : (isset($content->text) ? $content->text : 'Not Available');
            $tagsArray = [];
            foreach ($report->tags as $tag) {
                $tagsArray[] = $tag->name;
            }

            $posts[] = [
                'user' => $report->user->name,
                'post_id' => $report->post_id,
                'category' => $report->category ? $report->category : 'Not Specified',
                'platform' => $report->userAccount->platform->name,
                'message' => preg_replace('/#(\w+)/', '', $message),
                'tags' => $tagsArray,
                'created_at' => $report->updated_at->format('d/m/Y H:i:s a')
            ];
        }
    }
}
