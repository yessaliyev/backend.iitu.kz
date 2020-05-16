<?php

namespace App\Console\Commands;

use App\Models\Room;
use Illuminate\Console\Command;

class CreateRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-rooms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create rooms';

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
        for ($i = 1; $i<50; $i++){
            Room::firstOrCreate([
                'room_num' => $i + 300
            ]);
        }
    }
}
