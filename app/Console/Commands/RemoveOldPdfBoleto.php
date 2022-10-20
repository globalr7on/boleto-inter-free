<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class RemoveOldPdfBoleto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:remove-old-pdf-boleto {dir?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove todos os boletos e determinado diretório';

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

        $previousMonth = date("Y/m", strtotime("previous month"));

        $basePath =  base_path() . "/storage/app/boleto/pdf/";

        $dir = $this->argument("dir") ? $basePath . $this->argument("dir") : "{$basePath}$previousMonth";
       
        $this->info("Removendo os arquivos e diretório: {$dir}");

        $file = new Filesystem;

        $file->cleanDirectory($dir);

        @rmdir($dir);

        Artisan::call('cache:clear');
        $this->info("Diretório removido: {$dir}");
    }
}
