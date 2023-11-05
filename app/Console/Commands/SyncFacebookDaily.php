<?php

namespace App\Console\Commands;

use App\Repositories\SyncRepository;
use Illuminate\Console\Command;

class SyncFacebookDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-facebook-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrive Facebook users posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $syncFacebook = (new SyncRepository)->syncFacebook();
        $this->info('Retrived Facebook users posts Successfully');
    }
}
