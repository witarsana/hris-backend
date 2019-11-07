<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install The App';

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
        try {
            $this->info('Installing...');

            Artisan::call('key:generate');

            Artisan::call('migrate:fresh', [
                '--seed' => false
            ]);

            Artisan::call('passport:install', [
                '--force' => true
            ]);

            $this->info(config('app.name') . ' has been installed');
        } catch (\Exception $e) {
            $this->error('Error!');
            $this->error($e->getMessage());
        }
    }
}
