<?php

namespace App\Jobs;

use App\DTOs\ProductDTO;
use App\Services\ProductUpdateStrategy;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessUpdateProducts implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $csvLineData)
    {
        echo 'Processing product update for SKU: ' . ($this->csvLineData[0] ?? 'unknown') . PHP_EOL;
    }

    /**
     * Execute the job.
     */
    public function handle(ProductUpdateStrategy $strategy): void
    {
        $dto = ProductDTO::fromArray($this->csvLineData);
        $result = $strategy->execute($dto);

        // Log the result
        Log::info('Product update processed', $result);
    }

    /**
     * The unique ID for this job based on SKU
     */
    public function uniqueId(): string
    {
        // SKU is the unique identifier
        return 'product-update-' . ($this->csvLineData[0] ?? 'unknown');
    }

    public function failed(Exception $exception)
    {
        Log::alert('Failed to process update product for SKU: ' . ($this->csvLineData[0] ?? 'unknown') . '. Error: ' . $exception->getMessage());
    }
}
