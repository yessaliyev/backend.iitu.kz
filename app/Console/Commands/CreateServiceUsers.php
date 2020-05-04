<?php

namespace App\Console\Commands;

use App\Models\Users\ServiceUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\Report\PHP;

class CreateServiceUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-service-user';

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
        $access_token = Str::random(32);
        $refresh_token = Str::random(32);
        $user = new ServiceUser();
        $user->username = 'service_'.time();
        $user->access_token = password_hash($access_token,PASSWORD_DEFAULT);
        $user->refresh_token = password_hash($refresh_token,PASSWORD_DEFAULT);
        $user->access_token_expires_at = Carbon::now()->addMonths(3)->toDateString();
        $user->refresh_token_expires_at = Carbon::now()->addMonths(6)->toDateString();
        if ($user->save()){
            echo 'user: '.$user->username.PHP_EOL;
            echo 'access_token: '.$access_token.PHP_EOL;
            echo 'refresh_token: '.$refresh_token.PHP_EOL;
        }else{
            echo 'error';
        }

    }
}
