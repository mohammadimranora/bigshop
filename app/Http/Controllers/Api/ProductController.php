<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\Product;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required',
            'name' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->productRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = Product::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product not found!");
        }
        return $this->productRepository->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exists = Product::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product not found!");
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required',
            'name' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->productRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = Product::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product not found!");
        }
        return $this->productRepository->destroy($id);
    }
}
