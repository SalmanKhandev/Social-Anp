<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\TwitterRepository;

class Retweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retweet a tweet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $syncTwitter = (new TwitterRepository)->retweets();
        $this->info('Retrived Twitter tweets  Successfully');
    }
}
