<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductVariantRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    private ProductVariantRepositoryInterface $productVariantRepository;

    public function __construct(ProductVariantRepositoryInterface $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productVariantRepository->all();
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
            'product_id' => 'required|exists:products,id',
            'color' => 'required',
            'size' => 'required',
            'price' => 'required|numeric|between:0,9999999999.99',
            'stock' => 'required|numeric|between:0,9999999999'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->productVariantRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = ProductVariant::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product Variant not found!");
        }
        return $this->productVariantRepository->show($id);
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
        $exists = ProductVariant::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product Variant not found!");
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color' => 'required',
            'size' => 'required',
            'price' => 'required|numeric|between:0,9999999999.99',
            'stock' => 'required|numeric|between:0,9999999999'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->productVariantRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = ProductVariant::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product Variant not found!");
        }
        return $this->productVariantRepository->destroy($id);
    }
}
