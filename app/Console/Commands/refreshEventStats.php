<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class refreshEventStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:refreshAllStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh All Event Statistics';

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
        $ec=app()->make('App\Http\Controllers\EventsController');
        $ec->refreshAllEventStats();
        return 0;
    }
}
