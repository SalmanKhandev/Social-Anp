<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Repositories\HashTagsRepository;
use Illuminate\Http\Request;
use App\Repositories\PostsRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\UsersRepository;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public $settingsRepository;
    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }
    public function index(Request $request)
    {
        return view('reports.index', [
            'query' => $request->has('query') ? $request->get('query') : null,
            'users' => (new UsersRepository)->all(),
            'tags' => (new HashTagsRepository)->all(),
            'platforms' => $this->settingsRepository->platforms()
        ]);
    }

    public function getAll(Request $request)
    {

        $posts = [];
        $reports = Post::query();
        $reports->with('tags', 'user', 'userAccount.platform');

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

        $filter = $reports->orderBy('id', 'DESC')->get();


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
        return DataTables::of($posts)->make(true);
    }

    public function settings()
    {
        return view('settings.index');
    }

    public function deletePosts(Request $request)
    {
        $end_date = Carbon::now();
        $start_date = Carbon::now()->subDays($request->days);
        $posts = Post::whereBetween('created_at', [$start_date, $end_date])->delete();
        if ($posts) {
            return response()->json(['status' => true, 'message' => 'Posts deleted successfully']);
        }
    }
}
