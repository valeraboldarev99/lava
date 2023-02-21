<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'php artisan cache:clear + route:clear + view:clear + config:clear';

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
     * @return int
     */
    public function handle()
    {
        $cache_clear = Artisan::call('cache:clear');
        echo "cache cleared\n";
        $route_clear = Artisan::call('route:clear');
        echo "route cleared\n";
        $view_clear = Artisan::call('view:clear');
        echo "view cleared\n";
        $config_clear = Artisan::call('config:clear');
        echo "config cleared\n";

        return 'All cleared';
    }
}
