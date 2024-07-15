<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductPriceChanged;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // $page = request()->query('page', 1);
            // $size = request()->query('size', 10);
        
            $products = Product::with(['category', 'settings'])
                ->where('supplier_id', auth()->id())
                ->withTrashed()
                ->paginate(10);
            return ProductResource::collection($products);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch products.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
          
            $product = auth()->user()->products()->create($request->validated());
            if ($request->has('settings')) {
                foreach ($request->settings as $settingData) {
                    $setting = new Setting([
                        'price' => $settingData['price'],
                        'visibility' => $settingData['visibility'],
                        'main_picture' => '',
                        'colors' => $settingData['colors'],
                    ]);
                  
                    if (isset($settingData['main_picture']) && $settingData['main_picture']->isValid()) {
                        $path = $settingData['main_picture']->store('images/settings', 'public');
                        $fullUrl = url('storage/' . $path); 
                        $setting->main_picture = $fullUrl;
                    }
                    $product->settings()->save($setting);
                }
            }
            DB::commit();
            return new ProductResource($product->load('settings'));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to store product.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        DB::beginTransaction();
        try {
            $product->update($request->validated());

            $priceChanged = false;

            if ($request->has('settings') && $product->settings()->exists()) {
                foreach ($request->input('settings') as $settingData) {
                   
                    $existingSetting = $product->settings()->where('id', $settingData['id'] ?? null)->first();
                    
                    if ($existingSetting && $existingSetting->price != $settingData['price']) {
                        $priceChanged = true;
                        break;
                    }
                }
            }

           

            if ($priceChanged) {
                event(new ProductPriceChanged($product));
            }
            if ($request->has('settings_to_delete')) {
                $settingsIds = $request->input('settings_to_delete');
                $product->settings()->whereIn('id', $settingsIds)->delete();
            }
            if ($request->has('settings')) {
                foreach ($request->input('settings') as $settingData) {

                    $product->settings()->updateOrCreate(
                        ['id' => $settingData['id']],
                        [
                            'price' => $settingData['price'],
                            'main_picture' => '',
                            'visibility' => $settingData['visibility'],
                            'colors' => $settingData['colors'],
                        ]
                    );
                }
            }

            DB::commit();
            return new ProductResource($product);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update product.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('show', $product);
        try {
            return new ProductResource($product->load('settings','category'));
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch product.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        try {
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete product.', 'error' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);

            $this->authorize('restore', $product);

            $product->restore();

            return response()->json(['message' => 'Product restored successfully.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to restore product.', 'error' => $e->getMessage()], 500);
        }
    }
}

