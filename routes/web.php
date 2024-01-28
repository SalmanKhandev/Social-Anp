<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SyncTwitterController;
use App\Http\Controllers\FacebookPageController;
use App\Http\Controllers\SyncFacebookController;
use App\Http\Controllers\facebook\FacebookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});



Route::group(
    ['middleware' => ['web']],
    function () {
        Route::get('/testing', [TestingController::class, 'index']);
        Route::get('/auth/facebook', [FacebookController::class, 'redirectToFacebook']);
        Route::get('/auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);
        Route::get('showPermission', [FacebookController::class, 'showPermission']);
        Route::post('/register', [UsersController::class, 'register'])->name('user.register');
    }
);
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('permission:view admin dashboard');
    // Users Routes 
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name("dashboard.users.all")->middleware('permission:view user');
        Route::get('/show_agreement', [UsersController::class, 'userAgreement'])->name('user.show_agreement');
        Route::get('/approve_agreement', [UsersController::class, 'approveAgreement'])->name('approve.agreement');
        Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard')->middleware('permission:view user dashboard');
        Route::get('/profile', [UsersController::class, 'profile'])->name('users.profile');
        Route::get('/user-profile/{id}', [UsersController::class, 'userProfile'])->name('users.user-profile');
        Route::post('/update_status', [UsersController::class, 'updateStatus'])->name('user.updateStatus');
        Route::get("/thankyou/{user_id}", [UsersController::class, 'thankYou'])->name('user.thankyou');
        Route::get('/account_activation/{user_id}', [UsersController::class, 'accountActivation'])->name('user.accountActivation');
        Route::get('/account_deactivation/{user_id}', [UsersController::class, 'accountDeactivation'])->name('user.accountDeactivation');
        Route::post('/delete_user', [UsersController::class, 'deleteUser'])->name('user.deleteUser');
        Route::post('/update_user', [UsersController::class, 'updateUser'])->name('user.updateUser');
        Route::post('/assign-admin-role', [UsersController::class, 'assignAdminRole'])->name('user.assignAdminRole');
        Route::post('/assign-leader-role', [UsersController::class, 'assignLeaderRole'])->name('user.assignLeaderRole');
    });


    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name("dashboard.admins.all");
        Route::post('/create_admin', [AdminController::class, 'createAdmin'])->name('admin.createAdmin');
        Route::post('/update_admin', [AdminController::class, 'updateAdmin'])->name('admin.updateAdmin');
        Route::post('/delete_admin', [AdminController::class, 'deleteAdmin'])->name('admin.deleteAdmin');
    });

    Route::prefix('leaders')->group(function () {
        Route::get('/', [UsersController::class, 'listLeaders'])->name("dashboard.leaders.all");
        Route::post('/delete_leader', [UsersController::class, 'deleteLeader'])->name('leaders.deleteLeader');
    });

    // Posts Routes 
    Route::prefix('posts')->group(function () { // Use Route::group for nesting
        Route::get("/{user_id}/{platform_id}", [PostsController::class, "index"])->name("dashboard.posts.all");
    });
    Route::get("/categorize", [PostsController::class, "categorizePosts"])->name("dashboard.posts.categorize");

    // Sync Routes 
    Route::prefix('sync')->group(function () { // Use Route::group for nesting
        Route::post("/facebook_sync", [SyncFacebookController::class, "syncFacebookPosts"])->name("sync.facebook.posts");
        Route::post('/twitter_sync', [SyncTwitterController::class, "syncTwitterTweets"])->name("sync.twitter.tweets");
        Route::post('/retweet_sync', [TwitterController::class, "syncRetweets"])->name("sync.twitter.retweets");
        Route::post('/retweets', [TwitterController::class, "retweets"])->name("twitter.retweets");
    });


    // Reports Routes 
    Route::prefix('reports')->group(function () {
        Route::get("/", [ReportsController::class, "index"])->name("reports.index");
        Route::get("/all", [ReportsController::class, "getAll"])->name("reports.all");
    });

    Route::get("/all", [PostsController::class, "facebookPosts"])->name("facebook.posts");
    Route::get("/all_twitter_tweets", [PostsController::class, "twitterTweets"])->name("twitter.tweets");
    Route::get('/tweets', [TwitterController::class, 'tweets'])->name('tweets');
    Route::get('/get_all_tweets', [TwitterController::class, 'getAllTwitterTweets'])->name('twitter.all.tweets');
    Route::get("/user_posts", [PostsController::class, "userFacebookposts"])->name("user.facebook.posts");
    Route::get("/user_tweets", [TwitterController::class, "userTwitterTweets"])->name("name.twitter.tweets");
    Route::get("/twitter_trends", [TwitterController::class, "twitterTrends"])->name("twitter.trends");
    Route::get('/trending_tags', [TwitterController::class, 'getTrendingTags'])->name('trending.getTrendingTags');
    Route::post('/user_tweets', [TwitterController::class, 'userTweets'])->name('user.twitter.tweets');
    Route::post('/retweet_queue', [TwitterController::class, 'retweetQueue'])->name('twitter.retweetQueue');
    Route::get("/twitter", [PostsController::class, "twitterPosts"])->name("twitter.posts");
    Route::get("/instagram", [PostsController::class, "instagramPosts"])->name("instagram.posts");
    Route::get("/sync", [PostsController::class, "syncPosts"])->name("dashboard.posts.sync");
    Route::get("/categorize_posts", [PostsController::class, "nonCategorizePosts"])->name("categorize.posts.all");
    Route::post('/update_category_status', [PostsController::class, "updateCategoryStatus"])->name("category.updateCategoryStatus");
    Route::get('/setting', [ReportsController::class, "settings"])->name("posts.settings");
    Route::post('/set_post_deletion_date', [SettingsController::class, "setPostDeletionDate"])->name("posts.deletion.date");
    Route::post('/delete_posts', [ReportsController::class, "deletePosts"])->name("posts.deletePosts");
});

Auth::routes(['register' => false]);
Route::get('/register_user', [UsersController::class, 'registerForm'])->name('user.register.form');
Route::get('/auth/twitter', [TwitterController::class, 'redirectToTwitter'])->name('twitter.user.login');
Route::get('/auth/twitter/callback', [TwitterController::class, 'handleTwitterCallback']);
Route::get('/get-user-tweets', [TwitterController::class, 'getUserTweets'])->name('user.tweets');
Route::get('/facebook/page/{pageId}', [FacebookPageController::class, 'getPageData']);
Route::get('/signup', [SignUpController::class, 'signUp'])->name('user.signup');
Route::post('/signup_user', [SignUpController::class, 'signupUser'])->name('user.create.account');
Route::post('/run_tweets_jobs', [SyncTwitterController::class, "runTwitterJobs"])->name("sync.twitter.jobs");
