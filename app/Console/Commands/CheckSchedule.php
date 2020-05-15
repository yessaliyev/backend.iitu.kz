<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Block;
use App\Models\Day;
use App\Models\Department;
use App\Models\Group;
use App\Models\OTeacher;
use App\Models\Profession;
use App\Models\Regalia;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Specialty;
use App\Models\Subject;
use App\Models\SubjectType;
use App\Models\Time;
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

        $get_departments = $http->get('http://schedule.iitu.kz/rest/user/get_department.php?',[]);
        $get_departments = json_decode((string) $get_departments->getBody(), true);

        foreach ($get_departments['result'] as $get_department){
            $department = Department::firstOrCreate([
                'name_en' => $get_department['name_en'],
                'name_ru' => $get_department['name_ru'],
                'name_kk' => $get_department['name_kk'],
                'o_id' => $get_department['id'],
            ]);
        }

        $get_courses = $http->get('http://schedule.iitu.kz/rest/user/get_course.php',[]);
        $get_courses = json_decode((string) $get_courses->getBody(), true);

        foreach ($get_courses['result'] as $get_course){
            $get_specialties = $http->get('http://schedule.iitu.kz/rest/user/get_specialty.php?course='.$get_course,[]);
            $get_specialties = json_decode((string) $get_specialties->getBody(), true);

            foreach ($get_specialties['result'] as $get_specialty){

                $specialty = Specialty::firstOrCreate([
                    'name_en' => $get_specialty['name_en'],
                    'name_ru' => $get_specialty['name_ru'],
                    'name_kk' => $get_specialty['name_kk'],
                    'o_id' => $get_specialty['id'],
                ]);

                $get_groups = $http->get('http://schedule.iitu.kz/rest/user/get_group.php?course='.$get_course.'&specialty_id='.$get_specialty['id'],[]);
                $get_groups = json_decode((string) $get_groups->getBody(), true);

                foreach ($get_groups['result'] as $get_group){
//                    if ($get_group['id'] != '191561') continue;
                    $group = Group::firstOrCreate([
                        'name_en' => $get_group['name_en'],
                        'name_ru' => $get_group['name_ru'],
                        'name_kk' => $get_group['name_kk'],
                        'specialty_id' => $get_specialty['id'],
                        'o_id' => $get_group['id'],
                        'course' => $get_course
                    ]);

//                    $get_schedules = $http->get('http://schedule.iitu.kz/rest/user/get_timetable_block.php?block_id='.$get_group['id'],[]);
//                    $get_schedules = json_decode((string) $get_schedules->getBody(), true);
//
//                    foreach ($get_schedules['subjects'] as $key => $value){
//                        $subject = Subject::firstOrCreate([
//                            'o_id' => $key,
//                            'name_en' => $value['subject_en'],
//                            'name_ru' => $value['subject_ru'],
//                            'name_kk' => $value['subject_kk'],
//                        ]);
//                    }
//
//                    foreach ($get_schedules['subject_types'] as $key => $value){
//                        $type = SubjectType::firstOrCreate([
//                            'o_id' => $key,
//                            'type_en' => $value['subject_type_en'],
//                            'type_ru' => $value['subject_type_ru'],
//                            'type_kk' => $value['subject_type_kk']
//                        ]);
//                    }


//                    foreach ($get_schedules['teachers'] as $key => $value){
//                        $teacher = OTeacher::firstOrCreate([
//                            'o_id' => $key,
//                            'teacher_en' => $value['teacher_en'],
//                            'teacher_ru' => $value['teacher_ru'],
//                            'teacher_kk' => $value['teacher_kk'],
//                        ]);
//                    }
//
//                    foreach ($get_schedules['regalias'] as $key => $value){
//                        $regalia = Regalia::firstOrCreate([
//                            'o_id' => $key,
//                            'regalia_en' => $value['regalia_en'],
//                            'regalia_ru' => $value['regalia_ru'],
//                            'regalia_kk' => $value['regalia_kk'],
//                        ]);
//                    }
//
//                    foreach ($get_schedules['appointments'] as $key => $value){
//                        $appointment = Appointment::firstOrCreate([
//                            'o_id' => $key,
//                            'appointment_en' => $value['appointment_en'],
//                            'appointment_ru' => $value['appointment_ru'],
//                            'appointment_kk' => $value['appointment_kk'],
//                        ]);
//                    }

//                    foreach ($get_schedules['bundles'] as $key => $value){
//                        $room = Room::firstOrCreate([
//                            'o_id' => $key,
//                            'room_num' => json_encode($value,JSON_UNESCAPED_UNICODE),
//                        ]);
//                    }
//
//                    foreach ($get_schedules['blocks'] as $key => $value){
//                        $block = Block::firstOrCreate([
//                            'o_id' => $key,
//                            'name' => $value['name'],
//                            'o_group_id' => $get_group['id'],
//                        ]);
//                    }
//
//                    if (empty($get_schedules['timetable'])){
//                        var_dump([
//                            'course' => $get_course,
//                            'group' => $get_group,
//
//                        ]);
//                        continue;
//                    }
//                    foreach ($get_schedules['timetable'] as $key => $one_day){
//                        foreach ($one_day as $time_id => $item){
//                            $schedule = Schedule::firstOrCreate([
//                                'o_id'=> $item[0]['id'],
//                                'o_subject_id' => $item[0]['subject_id'],
//                                'o_subject_type_id'=>$item[0]['subject_type_id'],
//                                'o_group_id' => $item[0]['block_id'],
//                                'o_teacher_id' => $item[0]['teacher_id'],
//                                'o_regalia_id' => $item[0]['regalia_id'],
//                                'o_appointment_id' => $item[0]['appointment_id'],
//                                'o_room_id' => $item[0]['bundle_id'],
//                                'o_day_id' => $item[0]['day_id'],
//                                'o_time_id' => $item[0]['time_id'],
//                            ]);
//                        }
//                    }
                }

            }
        }

        exit;

        try {
            $shedule = $http->get('http://schedule.iitu.kz/rest/user/get_timetable_block.php?block_id=191485',[]);
        }catch (GuzzleHttp\Exception\BadResponseException $e){
            var_dump($e->getMessage());
        }



        var_dump( json_decode((string) $shedule->getBody(), true));


    }
}
