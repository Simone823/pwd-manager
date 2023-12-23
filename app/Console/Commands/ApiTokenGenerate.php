<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ApiTokenGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiToken:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera Token Api, stringa random di 64 caratteri';

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
        $apiToken = Str::random(64);
        $this->setEnv('APP_API_TOKEN', $apiToken);

        $this->info('Api Token generato con successo.');
    }

    private function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
            ));
        }
    }
}