<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductPriceChangedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;
    public $brand;
    public $supplier;

    /**
     * Create a new message instance.
     *
     * @param Product $product The product that has its price changed
     * @param Brand $brand The brand to notify about the price change
     */
    public function __construct(Product $product, Brand $brand, Supplier $supplier)
    {
        $this->product = $product;
        $this->brand = $brand;
        $this->supplier = $supplier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Product Price Changed Notification')
                    ->markdown('emails.product_price_changed');
    }
}
