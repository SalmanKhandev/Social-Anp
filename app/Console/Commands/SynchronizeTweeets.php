<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\SyncRepository;
use App\Repositories\TwitterRepository;

class SynchronizeTweeets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:synchronize-tweeets.php';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run:tweets after every 30 mins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $retweets = (new SyncRepository)->syncTwitter();
        $this->info('Retrived Twitter tweets  Successfully');
    }
}
