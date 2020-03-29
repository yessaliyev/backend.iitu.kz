<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Models\Role;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-admin {username} {password}';

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
        $user = User::create([
            'username' => $this->argument('username'),
            'password' => bcrypt($this->argument('password')),
        ]);


        $role = Role::firstOrCreate(['role'=>'admin']);

        $user = User::find($user->id);

        $user->roles()->attach($role->id);

        return $user;
    }
}
