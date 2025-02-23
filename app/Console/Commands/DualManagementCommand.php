<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UserService;

class DualManagementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dual-management-command {sub} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DBとCognitoの二重管理のコードをテストするコマンド';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userService = new \App\Services\UserService();
        $user = new \App\Models\User();
        $userService->syncUser($user, [
                'sub' => $this->argument('sub'),
                'email' => $this->argument('email'),
                'username' => 'Satoshi Kaneyasu',
                'first_name' => 'Kaneyasu',
                'last_name' => 'Kaneyasu',
                'phone_number' => '999-1234-5678',
            ]
        );
    }
}
