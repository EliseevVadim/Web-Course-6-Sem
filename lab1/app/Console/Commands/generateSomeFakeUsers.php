<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class generateSomeFakeUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-some-fake-users {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle()
    {
        $usersCount = $this->argument('count');
        User::factory()->count($usersCount)->create();
    }
}
