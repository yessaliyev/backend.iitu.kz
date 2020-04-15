<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TaskUpload as Task;

class Upload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:upload {task_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upload file';

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
        $task = Task::find($this->argument('task_id'));
        if (empty($task)) $this->error('Something went wrong!');

        

    }
}
