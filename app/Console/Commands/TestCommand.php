<?php

namespace App\Console\Commands;

use App\Classes\WeMob\WeMobClient;
use App\Imports\UsersImport;
use App\Models\RepairOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test {filepath}';

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
        Excel::import(new UsersImport, $this->argument('filepath'));
    }
}
