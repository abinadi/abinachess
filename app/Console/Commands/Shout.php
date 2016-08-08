<?php

namespace AbinaChess\Console\Commands;

use AbinaChess\Shout as ShoutModel;
use Illuminate\Console\Command;

class Shout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abinachess:shout';

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
		$shout = ShoutModel::find(1);

		event(new \AbinaChess\Events\ShoutWasPosted($shout));
    }
}
