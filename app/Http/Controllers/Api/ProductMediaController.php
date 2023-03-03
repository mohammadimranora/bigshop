<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductMediaRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\ProductMedia;

class ProductMediaController extends Controller
{
    private ProductMediaRepositoryInterface $productMediaReposistory;

    public function __construct(ProductMediaRepositoryInterface $productMediaReposistory)
    {
        $this->productMediaReposistory = $productMediaReposistory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productMediaReposistory->all();
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
            'media' => 'required|max:10000|mimes:jpg,bmp,png,jpeg',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->productMediaReposistory->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = ProductMedia::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product Media not found!");
        }
        return $this->productMediaReposistory->show($id);
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
        $exists = ProductMedia::where('id', $id)->exists();

        if (!$exists) {
            return ResponseHelper::error("Product Media not found!");
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'media' => 'max:10000|mimes:jpg,bmp,png,jpeg',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->productMediaReposistory->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = ProductMedia::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Product Media not found!");
        }
        return $this->productMediaReposistory->destroy($id);
    }
}
