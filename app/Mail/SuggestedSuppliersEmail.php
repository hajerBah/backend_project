<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuggestedSuppliersEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $brand;
    public $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($brand, $product)
    {
        $this->brand = $brand;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.suggested_suppliers')
                    ->subject('Suggested Suppliers for ' . $this->brand->name);
    }
}
