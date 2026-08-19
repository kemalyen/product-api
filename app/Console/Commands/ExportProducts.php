<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

#[Signature('export-products {--status= : Only export products with this status}')]
#[Description('Export products to a CSV file')]
class ExportProducts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filename = 'products-' . now()->format('Ymd-His') . '.csv';
        $filePath =  'out/' . $filename;
        $temporaryPath = tempnam(sys_get_temp_dir(), 'product-export-');

        if ($temporaryPath === false) {
            $this->error('Unable to create a temporary export file.');
            return self::FAILURE;
        }

        $stream = null;

        try {
            $stream = fopen($temporaryPath, 'w+b');

            if ($stream === false) {
                throw new RuntimeException('Unable to open the temporary export file.');
            }

            fputcsv($stream, [
                'sku',
                'barcode',
                'name',
                'description',
                'published_at',
                'status',
                'price',
                'stock',
            ]);

            $query = Product::query()->orderBy('id');

            if ($status = $this->option('status')) {
                $query->where('status', $status);
            }

            $exportedProducts = 0;
            $query->chunkById(500, function ($products) use ($stream, &$exportedProducts): void {
                foreach ($products as $product) {
                    fputcsv($stream, [
                        $product->sku,
                        $product->barcode,
                        $product->name,
                        $product->description,
                        $product->published_at?->format('Y-m-d H:i:s'),
                        $product->status,
                        $product->price,
                        $product->stock,
                    ]);

                    $exportedProducts++;
                }
            });

            rewind($stream);
            if (!Storage::disk('internal')->writeStream($filePath, $stream)) {
                throw new RuntimeException("Unable to write the export file to the disk.");
            }

            $this->info("Exported {$exportedProducts} products to {$filePath} on the disk.");

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('Product export failed: ' . $exception->getMessage());

            return self::FAILURE;
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }

            unlink($temporaryPath);
        }
    }
}
