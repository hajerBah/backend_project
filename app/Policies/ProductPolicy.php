<?php 

namespace App\Policies;

use App\Models\Product;
use App\Models\Supplier;


class ProductPolicy
{
    /**
     * Determine if the given product can be updated by the supplier.
     *
     * @param  \App\Models\supplier  $supplier
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function update(Supplier $supplier, Product $product)
    {
        return $supplier->id === $product->supplier_id;
    }

    /**
     * Determine if the given product can be shown to the supplier.
     *
     * @param  \App\Models\Supplier  $supplier
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function show(Supplier $supplier, Product $product)
    {
        return $supplier->id === $product->supplier_id;
    }

    /**
     * Determine if the given product can be deleted by the supplier.
     *
     * @param  \App\Models\supplier  $supplier
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function delete(Supplier $supplier, Product $product)
    {
        return $supplier->id === $product->supplier_id;
    }

    public function restore(Supplier $supplier, Product $product)
{
    return $supplier->id === $product->supplier_id;
}
}
