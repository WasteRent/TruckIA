<?php

namespace App\Console\Commands;

use App\Classes\WeMob\WeMobClient;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $wemob = new WeMobClient(
            config('wemob.base_url'),
            config('wemob.acciona.username'),
            config('wemob.acciona.password')
        );

        dd($wemob->getData());
    }
}
