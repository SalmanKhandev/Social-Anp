<?php

namespace App\Console\Commands;

use App\Repositories\TwitterRepository;
use Illuminate\Console\Command;

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
        $syncTwitter = (new TwitterRepository)->runTwitterJobs();
        $this->info('Retrived Twitter tweets  Successfully');
    }
}
