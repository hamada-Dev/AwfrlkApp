<?php

namespace App\Console\Commands;

use App\Models\Roomcart;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteCart:check';

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
     * @return mixed
     */
    public function handle()
    {
        Roomcart::first()->delete();
    }
}
