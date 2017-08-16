<?php

namespace App\Console\Commands;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:user:create {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an administrator or set user to administrator.';

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
        $username = $this->argument('username');
        $admin = Administrator::where('username', $username)->first();
        if ($admin) {
            $this->warn("User '$username' already exists.");
        } else {
            $admin = new Administrator();
            $admin->username = $username;
            $admin->password = '*';
            $admin->name = ucfirst($username);
            $admin->save();
            $this->info("User '$username' created.");
        }
        if ($admin->isAdministrator()) {
            $this->warn("User '$username' is an administrator.");
        } else {
            $administrator_roles = Role::where('slug', 'administrator')->get();
            $admin->roles()->attach($administrator_roles);
            $this->info("Set user '$username' as administrator OK.");
        }
    }
}
