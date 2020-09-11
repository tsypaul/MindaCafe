<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;

class RegisterAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:add-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a admin user';

    private $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $info = $this->getUserInfo();

        try {
            $this->user->createAdmin($info);
        } catch (Exception $e) {
            $this->error("User or email exists");
            $this->handle();
        }

        $this->info("New admin user created");
    }

    private function getUserInfo()
    {
        $info['name'] = $this->ask('name');
        $info['email'] = $this->ask('email');
        $info['password'] = $this->secret('password');
        $confirm_pwd = $this->secret('confirm_password');

        while (!($this->isMatch($info['password'], $confirm_pwd) && $this->checkLength($info['password']))) {
            if (!$this->isMatch($info['password'], $confirm_pwd)) {
                $this->error("Passwords do not match");
            }

            if (!$this->checkLength($info['password'])) {
                $this->error("Password length must have 8 or more characters");
            }

            $info['password'] = $this->secret('password');
            $confirm_pwd = $this->secret('confirm_password');
        }

        $info['password'] = Hash::make($info['password']);

        return $info;
    }

    private function isMatch($pwd, $confirm_pwd)
    {
        return $pwd === $confirm_pwd;
    }

    private function checkLength($pwd)
    {
        return strlen($pwd) > 7;
    }
}
