<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers;

class LookupCallsigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:lookup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'QRZ Lookup callsigns in the event_logs table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ec=app()->make('App\Http\Controllers\EmailController');
        $ec->QRZ_Event();
        return 0;
    }
}
