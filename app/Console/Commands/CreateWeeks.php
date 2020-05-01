<?php

namespace App\Console\Commands;

use App\Models\Week;
use Illuminate\Console\Command;

class CreateWeeks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-weeks {start_day}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'will create 14 weeks';

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
        $start = $this->argument('start_day');
        for ($i = 0; $i<14; $i++){

            $end = date('Y-m-d', strtotime($start. ' + 7 days'));
            $interval = json_encode([$start,$end],JSON_UNESCAPED_UNICODE);

            Week::firstOrCreate([
                'start' => $start,
                'end' => $end,
                'week_num' => $i+1,
                'status' => Week::DEFAULT_WEEK
            ]);
            $start = date('Y-m-d', strtotime($end. ' + 1 days'));

        }


    }
}
