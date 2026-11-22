<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeCommand extends Command
{
    protected $signature = 'serve {--host=127.0.0.1} {--port=8000}';
    protected $description = 'Serve the application on the PHP development server';

    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        $publicPath = public_path();
        $serverFile = base_path('vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php');

        chdir($publicPath);

        $this->components->info("Server running on [http://{$host}:{$port}].");
        $this->comment('  Press Ctrl+C to stop the server');

        passthru(sprintf(
            '"%s" -S %s:%s "%s"',
            PHP_BINARY,
            $host,
            $port,
            $serverFile
        ));
    }
}