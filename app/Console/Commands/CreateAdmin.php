<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Models\Role;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-admin {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'will be generated admin';

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
        $role = Role::firstOrCreate(['role'=>'admin']);

        return User::create([
            'username' => $this->argument('username'),
            'password' => bcrypt($this->argument('password')),
            'role_id' =>  $role->id
        ]);

    }
}
