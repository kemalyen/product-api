<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAccountPrice;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('update-price-list')]
#[Description('Reading price list files from storage and updating the prices accordingly')]
class UpdatePriceList extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('internal')->files('in');
        foreach ($files as $file) {
            if (str_contains($file, 'price_list')) {
                $this->info("Processing file: $file");
                $data = Storage::disk('internal')->get($file);
                $skip_first_line = 1;
                foreach (explode("\n", $data) as $line) {
                    $this->info("Processing line: $line");
                    if ($skip_first_line) {
                        $skip_first_line = 0;
                        continue;
                    }
                    UpdateAccountPrice::dispatch(...explode(',', $line));
                }
                Storage::disk('internal')->move($file, str_replace('in', 'processed', $file));
            }
        }
    }
}
