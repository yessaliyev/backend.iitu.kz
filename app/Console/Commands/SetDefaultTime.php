<?php

namespace App\Console\Commands;

use App\Models\Day;
use App\Models\Time;
use Illuminate\Console\Command;
use GuzzleHttp;


class SetDefaultTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:set-default-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get time and days from schedule.iitu.kz';

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
        $http = new GuzzleHttp\Client;

        $get_days = $http->get('http://schedule.iitu.kz/rest/time/get_day.php');
        $get_days = json_decode((string) $get_days->getBody(), true);

        foreach ($get_days['result'] as  $get_day){
            $day = Day::firstOrCreate([
                'name_en' => $get_day['name_en'],
                'name_ru' => $get_day['name_ru'],
                'name_kk' => $get_day['name_kk'],
                'o_id' => $get_day['id']
            ]);
        }

        $get_times = $http->get('http://schedule.iitu.kz/rest/time/get_time.php');
        $get_times = json_decode((string) $get_times->getBody(), true);

        foreach ($get_times['result'] as $get_time){
            $time = Time::firstOrCreate([
                'start_time' => date('H:i:s',strtotime($get_time['startTime'])),
                'end_time' => date('H:i:s',strtotime($get_time['endTime'])),
                'o_id' => $get_time['id']
            ]);
        }
    }
}
