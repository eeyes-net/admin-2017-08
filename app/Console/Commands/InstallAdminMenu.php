<?php

namespace App\Console\Commands;

use Encore\Admin\Auth\Database\Menu;
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
        $menus = [
            ['title' => 'API log', 'icon' => 'fa-history', 'uri' => 'api_logs'],
        ];
        foreach ($menus as $menu) {
            /** @var Menu $menu_model */
            $menu_model = Menu::firstOrNew(['uri' => $menu['uri']]);
            if ($menu_model->exists) {
                $this->info("Menu {$menu['title']} already exist");
            } else {
                $menu_model->title = $menu['title'];
                $menu_model->icon = $menu['icon'];
                $menu_model->save();
                $this->info("Menu {$menu['title']} added ok");
            }
        }
    }
}
