<?php

namespace App\Listeners;

use App\Events\ProductPriceChanged;
use App\Mail\ProductPriceChangedNotification;
use App\Models\Brand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendProductPriceChangedNotification implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
       
    }

    /**
     * Handle the event.
     */
    public function handle(ProductPriceChanged $event)
    {
        $product = $event->product;

        $supplier = $product->supplier;
    
        $brands = Brand::where('category_id', $product->category_id)->get();
        
        foreach ($brands as $brand) {
            Mail::to($brand->email)->send(new ProductPriceChangedNotification($event->product, $brand,  $supplier));
        }
    }

    /**
     * Determine whether the listener should be queued.
     */
    public function shouldQueue(ProductPriceChanged $event): bool
    {
        return true;
    }
}
