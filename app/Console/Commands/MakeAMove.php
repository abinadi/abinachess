<?php

namespace AbinaChess\Console\Commands;

use AbinaChess\Game;
use Illuminate\Console\Command;

class MakeAMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abinachess:move';

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
		$game = Game::random();

		event(new \AbinaChess\Events\MoveWasMade($game));
    }
}

