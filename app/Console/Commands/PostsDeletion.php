<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostSetting;
use Illuminate\Console\Command;

class PostsDeletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:posts-deletion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletion Posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = PostSetting::first();
        Post::where("created_at", "<", $date->post_deletion_date)->delete();
        $this->info('Deleted Facebook  posts Successfully');
    }
}
