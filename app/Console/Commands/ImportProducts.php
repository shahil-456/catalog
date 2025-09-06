<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ImportProducts extends Command
{
    protected $signature = 'products:import {file}';
    protected $description = 'Import products from an Excel/CSV file';

    public function handle()
    {
        $file = $this->argument('file');

        $path = public_path($file);

        if (!file_exists($path)) {
            $this->error("File not found: {$path}");
            return 1; 
        }

        Excel::queueImport(new ProductsImport, $path);
        $this->info("Import queued for file: {$path}");
    }

}
