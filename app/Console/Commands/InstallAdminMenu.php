<?php

namespace App\Console\Commands;

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Console\Command;

class InstallAdminMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:menu:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create self defined admin page in menu list';

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
        $menus_data = [
            ['title' => 'API log', 'icon' => 'fa-history', 'uri' => 'api_logs', 'roles' => ['administrator']],
        ];
        foreach ($menus_data as $menu_data) {
            /** @var Menu $menu */
            $menu = Menu::firstOrNew(['uri' => $menu_data['uri']]);
            if ($menu->exists) {
                $this->info("Menu {$menu_data['title']} already exist");
            } else {
                $menu->title = $menu_data['title'];
                $menu->icon = $menu_data['icon'];
                $menu->save();
                $this->info("Menu {$menu_data['title']} added ok");
            }
            if (isset($menu_data['roles'])) {
                $roles = Role::whereIn('slug', $menu_data['roles'])->get();
                $menu->roles()->sync($roles);
                $this->info("Menu {$menu_data['title']} set roles ok");
            }
        }
    }
}
