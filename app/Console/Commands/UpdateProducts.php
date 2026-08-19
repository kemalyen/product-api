<?php

namespace App\Console\Commands;

use App\Jobs\ProcessUpdateProducts;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

#[Signature('update-products')]
#[Description('Updating the products in the database based on the latest data')]
class UpdateProducts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('internal')->files('in');

        foreach ($files as $file) {
            if (str_contains($file, 'products')) {
                $this->info("Processing the products file: $file");
                $data = Storage::disk('internal')->readStream($file);
                $skip_first_line = 1;
                while (($line = fgetcsv($data, null, ',')) !== false) {

                    if ($skip_first_line) {
                        $skip_first_line = 0;
                        continue;
                    }
                    $this->info("Processing line: $line[0]");
                    ProcessUpdateProducts::dispatch($line);
                }
                Storage::disk('internal')->move($file, str_replace('in/', 'processed/', $file));
            }
        }
    }
}
