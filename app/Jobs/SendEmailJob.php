<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuggestedSuppliersEmail;
use App\Models\Product;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $brands = Brand::all();

        // foreach ($brands as $brand) {
        //     $categories = [$brand->category_id];
        //     foreach ($brand->searchHistories as $history) {
               
        //         $categoryId = $history->terms[0];
        //         if (!in_array($categoryId , $categories)) {
        //             array_push($categories,$categoryId);
        //         }
        //     }
        //     $suppliers = Supplier::whereHas('categories', function ($query) use ($categories) {
        //         $query->whereIn('id', $categories);
        //     })->inRandomOrder()
        //     ->take(10)
        //     ->get();
        //     Mail::to($brand->email)->send(new SuggestedSuppliersEmail($brand, $suppliers));
        // }
            $product  = $this->product->load('supplier','category');
            foreach ($brands as $brand) {
                $categories = [$brand->category_id];
                foreach ($brand->searchHistories as $history) {
                
                    $categoryId = $history->terms[0];
                    if (!in_array($categoryId , $categories)) {
                        array_push($categories,$categoryId);
                    }
                }
               
                Mail::to($brand->email)->send(new SuggestedSuppliersEmail($brand, $product));
                
           
            }

    }
}
