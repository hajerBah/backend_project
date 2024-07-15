<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "deleting" event.
     */
    public function deleting(Product $product): void
    {
        $product->settings()->delete();
    }

    /**
     * Handle the Product "restoring" event.
     */
    public function restoring(Product $product): void
    {
        $product->settings()->withTrashed()->restore();
    }

        /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        SendEmailJob::dispatch($product)->delay(10);
    }

   
}
