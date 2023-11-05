<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Platform;
use App\Repositories\HashTagsRepository;
use Illuminate\Http\Request;
use App\Repositories\PostsRepository;
use App\Repositories\UsersRepository;

class DashboardController extends Controller
{

    public $postsRepository;
    public $UsersRepository;
    public $tagsRepository;
    public function __construct(PostsRepository $postsRepository, UsersRepository $usersRepository, HashTagsRepository $tagsRepository)
    {
        $this->postsRepository = $postsRepository;
        $this->UsersRepository = $usersRepository;
        $this->tagsRepository = $tagsRepository;
    }

    public function index()
    {
        $data['users'] = $this->UsersRepository->countUsers();
        $data['facebook'] = $this->postsRepository->getPostsByPlatform('Facebook');
        $data['twitter'] =  $this->postsRepository->getPostsByPlatform('Twitter');
        $data['instagram'] = $this->postsRepository->getPostsByPlatform('Instagram');
        $data['top_users'] =  $this->UsersRepository->topUsers();
        $data['tags'] = $this->tagsRepository->trendingPosts()->groupBy('name');
        $data['chart_data'] = $this->postsRepository->chartData();
        return view('dashboard.index', ['data' => $data]);
    }
}
