<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\ProductVariantRepositoryInterface;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantRepository implements ProductVariantRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $productVariants = ProductVariant::all();
        return ResponseHelper::success("Success", $productVariants);
    }

    /**
     * create a product variant
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productVariant = ProductVariant::updateOrCreate([
            'product_id' => $request->product_id,
            'color' => $request->color,
            'size' => $request->size
        ], $request->all());
        return ResponseHelper::success('Product Variant Created/Updated', $productVariant, 201);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $productVariant = ProductVariant::where('id', $id)->first();
        return ResponseHelper::success("Product Variant Details", $productVariant);
    }

    /**
     * update a product variant
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $productVariant = ProductVariant::where('id', $id)->first();
        $productVariant->update($request->all());
        $productVariant->save();
        return ResponseHelper::success("Product Variant Updated", $productVariant);
    }

    /**
     * destroy a product variant
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $productVariant = ProductVariant::where('id', $id)->first();
        $productVariant->delete();
        return ResponseHelper::success('Product Variant Deleted');
    }
}
