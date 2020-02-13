<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp;

class CheckSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'will check schedule every min';

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

        $time = $http->get('http://schedule.iitu.kz/rest/time/get_time.php', []);
        $days = $http->get('http://schedule.iitu.kz/rest/time/get_day.php',[]);
        $departments = $http->get('http://schedule.iitu.kz/rest/user/get_department.php?',[]);
        $specialties = $http->get('http://schedule.iitu.kz//rest/user/get_specialty.php?course=1',[]);
        $groups = $http->get('http://schedule.iitu.kz/rest/user/get_group.php?course=3&specialty_id=15100',[]);
        try {
            $shedule = $http->get('http://schedule.iitu.kz/rest/user/get_timetable_block.php?block_id=191485',[]);
        }catch (GuzzleHttp\Exception\BadResponseException $e){
            var_dump($e->getMessage());
        }



        var_dump( json_decode((string) $shedule->getBody(), true));


    }
}
