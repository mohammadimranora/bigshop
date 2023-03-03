<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $products = Product::all();
        return ResponseHelper::success("Success", $products);
    }

    /**
     * create a product
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return ResponseHelper::success('Product Created', $product, 201);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return ResponseHelper::success("Product Details", $product);
    }

    /**
     * update a product
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $product->update($request->all());
        $product->save();
        return ResponseHelper::success("Product Updated", $product);
    }

    /**
     * destroy a product
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product->delete();
        return ResponseHelper::success('Product Deleted');
    }

    /**
     * raise a product view count
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function productView($id)
    {
        Product::find($id)->increment('view_count');
        return ResponseHelper::success('Product View Count Raised');
    }
}
