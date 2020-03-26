<?php

namespace App\Console\Commands;

use App\Models\SubjectType;
use Illuminate\Console\Command;

class AddSubjectTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-subject-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command will add subject types';

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
        $types = [
            1 => [
                'type_en'=>'lecture',
                'type_ru'=>'лекция',
                'type_kk'=>'дәріс'
            ],
            2 => [
                'type_en'=>'practice',
                'type_ru'=>'практика',
                'type_kk'=>'тәжірибе'
            ],
            3 => [
                'type_en'=>'lab',
                'type_ru'=>'лабораторная работа',
                'type_kk'=>'зертханалық жұмыс'
            ]
        ];

        foreach ($types as $key => $value){
            SubjectType::firstOrCreate([
                'type_en' => $value['type_en'],
                'type_ru' => $value['type_ru'],
                'type_kk' => $value['type_kk']
            ]);
        }

    }
}
