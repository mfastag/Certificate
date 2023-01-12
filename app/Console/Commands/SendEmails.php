<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:blast {eventid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the email blast for an event';

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
        if(!$this->argument('eventid')) return;
        $ec=app()->make('App\Http\Controllers\EmailController');
        $ec->sendEventBlast($this->argument('eventid'));
        return 0;
    }
}
