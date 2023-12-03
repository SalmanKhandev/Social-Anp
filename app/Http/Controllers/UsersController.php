<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Post;
use App\Models\User;
use App\Mail\thankYouEmail;
use Illuminate\Http\Request;
use App\Jobs\ThankYouEmailJob;
use PhpParser\Node\Stmt\TryCatch;
use App\Jobs\AccountActivationJob;
use App\Jobs\AccountDeactivationJob;
use App\Models\Platform;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\HashTagsRepository;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
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
        $users = User::withWhereHas('roles', function ($role) {
            $role->where('name', 'User');
        })->with('userAccounts.platform')->paginate(50);
        return view('users.index', ['users' => $users]);
    }

    public function dashboard()
    {
        $data['facebook_top_users'] = $this->UsersRepository->FacebookTopUsers();
        $data['twitter_top_users'] = $this->UsersRepository->twitterTopUsers();
        $data['facebook_tags'] = $this->tagsRepository->facebookTrendingPosts()->where('posts_count', '>', 0)->groupBy('name');
        $data['twitter_tags'] = $this->tagsRepository->twitterTrendingTweets()->where('posts_count', '>', 0)->groupBy('name');
        return view('users.dashboard', ['data' => $data]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|',
            'password-confirm' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('user.register.form')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        $user->designation = $request->designation;
        $user->dob = $request->dob;
        $user->residence = $request->residence;
        $user->about = $request->about;
        $user->save();

        Auth::loginUsingId($user->id);
        return redirect()->route('user.show_agreement');
        // return redirect()->route('login')->with('message', 'You are registered successfully please wait until Admin approve your account !');
    }

    public function registerForm()
    {
        $user = session('user');
        return view('auth.register', compact('user'));
    }

    public function updateStatus(Request $request)
    {
        $user = $this->UsersRepository->findUserById($request->id);
        $user->status = $request->status;
        $user->save();
        if ($request->status == 0) {
            $this->UsersRepository->accountDeactivation($user->id);
        } else {
            $this->UsersRepository->accountActivation($user->id);
        }
        return response()->json(['success' => true, 'message' => 'User Status Updated Successfully']);
    }

    public function profile()
    {
        $posts = Post::where('user_id', auth()->user()->id)->with(['tags', 'user', 'userAccount.platform' => function ($query) {
            $query->where('name', 'Facebook');
        }])->get();
        $groupedPosts  = $posts->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });

        $userTwitterProfile = UserAccount::where('user_id', auth()->user()->id)
            ->where('platform_id', Platform::$TWITTER)->first();
        return view('users.profile', compact("groupedPosts", "userTwitterProfile"));
    }

    public function userProfile($id)
    {
        $posts = Post::where('user_id', $id)->with(['tags', 'user', 'userAccount.platform' => function ($query) {
            $query->where('name', 'Facebook');
        }])->get();
        $groupedPosts  = $posts->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });
        $user = User::with('userAccounts')->where('id', $id)->first();
        $userTwitterProfile = UserAccount::where('user_id', $id)
            ->where('platform_id', Platform::$TWITTER)->first();
        return view('users.show-profile', compact("groupedPosts", "user", "userTwitterProfile"));
    }

    public function userAgreement(Request $request)
    {
        return view('users.about_me');
    }

    public function approveAgreement(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if ($request->approval_status == "declined") {
            return redirect()->route('login')->with('message', 'You are registered successfully please wait until Admin approve your account !');
        } else {
            $user->profile_permission = 1;
            $user->save();
            return redirect()->route('login')->with('message', 'You are registered successfully please wait until Admin approve your account !');
        }
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('id', $request->user_id)->delete();
        if ($user) {
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        }
    }

    public function updateUser(UserRequest $request)
    {
        if ($this->UsersRepository->updateUser($request)) {
            return response()->json(['success' => true, 'message' => 'User Updated successfully']);
        }
    }

    public function assignAdminRole(Request $request)
    {
        $user = $this->UsersRepository->findUserById($request->user_id);
        $assignRole = $user->syncRoles(['Admin']);
        if ($assignRole) {
            return response()->json(['success' => true, 'message' => 'Admin Role Assign to this User  successfully']);
        }
    }
}
