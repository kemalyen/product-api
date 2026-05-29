<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateAccountPrice implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    private Product $product;
    private Account $account;
    private float $price;

    /**
     * Create a new job instance.
     */
    public function __construct(int|string $account_id, int|string $product_id, mixed $price)
    {
        $this->product = Product::whereSku($product_id)->first();
        $this->account = Account::whereAccountNumber($account_id)->first();
        $this->price = (float) $price;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->product && $this->account) {
            ProductPrice::updateOrCreate(
                ['account_id' => $this->account->id, 'product_id' => $this->product->id],
                ['price' => $this->price]
            );
        }
    }

    public function uniqueId(): string
    {
        return (string) $this->product->id;
    }
}
