<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Models\Tag;
use App\Models\Post;
use App\Repositories\PostsRepository;
use Illuminate\Http\Request;
use App\Repositories\UsersRepository;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends Controller
{
    public  $postsRepository;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }
    public function index($user_id, $platform_id)
    {
        $posts = Post::where('user_id', $user_id)->with('tags', 'user', 'userAccount.platform')->whereHas('userAccount', function ($query) use ($platform_id) {
            // $query->where('platform_id', Platform::$FACEBOOK);
            $query->where('platform_id', $platform_id);
        })->get();
        $groupedPosts  = $posts->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });

        return view('posts.index', ['groupedPosts' => $groupedPosts]);
    }

    public function all()
    {
        dd("Asdfasdfasda");
    }

    public function facebookPosts()
    {
        $posts = Post::with('tags', 'user', 'userAccount.platform')
            ->whereHas('userAccount.platform', function ($query) {
                $query->where('name', 'Facebook');
            });
        $groupedPosts  = $posts->get()->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });
        $allPosts = $posts->paginate(20);
        return view('posts.facebook', ['allPosts' => $allPosts, 'groupedPosts' => $groupedPosts]);
    }


    public function twitterTweets()
    {
        $posts = Post::with('tags', 'user', 'userAccount.platform')
            ->whereHas('userAccount.platform', function ($query) {
                $query->where('name', 'Twitter');
            })->withCount('retweets')->orderBy('id', 'DESC');
        $groupedPosts  = $posts->get()->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });

        $allTweets = $posts->paginate(50);
        return view('posts.twitter', ['allTweets' => $allTweets, 'groupedPosts' => $groupedPosts]);
    }

    public function twitterPosts()
    {
    }

    public function instagramPosts()
    {
    }

    public function userFacebookposts()
    {
        $facebookPosts = $this->postsRepository->getPostAndTweets('Facebook');
        return view('users.facebook_posts', ['groupedPosts' => $facebookPosts]);
    }

    public function syncPosts()
    {
        return view('posts.sync');
    }

    public function categorizePosts(Request $request)
    {
        return view('categorize.index', [
            'query' => $request->has('query') ? $request->get('query') : null,
            'users' => (new UsersRepository)->all(),
        ]);
    }

    public function nonCategorizePosts(Request $request)
    {
        $posts = [];
        $reports = Post::orderBy('id', 'DESC')->whereNull('category')->with('tags', 'user', 'userAccount.platform');

        if (!empty($request->user_id)) {
            $reports->where('user_id', $request->user_id);
        }

        if (!empty($request->from_date)) {
            $reports->whereDate('created_at', '>=', $request->from_date);
        }

        if (!empty($request->end_date)) {
            $reports->whereDate('created_at', '<=', $request->end_date);
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
                'id' => $report->id,
                'user' => $report->user->name,
                'post_id' => $report->post_id,
                'platform' => $report->userAccount->platform?->name,
                'message' => preg_replace('/#(\w+)/', '', $message),
                'tags' => $tagsArray,
            ];
        }
        return DataTables::of($posts)->make(true);
    }

    public function updateCategoryStatus(Request $request)
    {
        $update =  Post::where('id', $request->post_id)
            ->update(['category' => $request->post_type]);
        return response()->json($update);
    }
}
