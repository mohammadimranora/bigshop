<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\ProductMediaRepositoryInterface;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Http\Request;

class ProductMediaRepository implements ProductMediaRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $products = ProductMedia::all();
        return ResponseHelper::success("Success", $products);
    }

    /**
     * create a product media
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = md5(time()) . '.' . $request->media->getClientOriginalExtension();
        $data = [
            'product_id' => $request->product_id,
            'media' => ProductMedia::UPLOAD_PATH . $filename,
            'status' => $request->status
        ];

        $request->media->move(public_path(ProductMedia::UPLOAD_PATH), $filename);
        $productMedia = ProductMedia::create($data);
        return ResponseHelper::success('Product Media Created', $productMedia, 201);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductMedia::where('id', $id)->first();
        return ResponseHelper::success("Product Media Details", $product);
    }

    /**
     * update a product media
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $productMedia = ProductMedia::where('id', $id)->first();
        $filename = $productMedia->media;
        $newfilename = '';
        if ($request->hasFile('media')) {
            $newfilename = md5(time()) . '.' . $request->media->getClientOriginalExtension();
            $request->media->move(public_path(ProductMedia::UPLOAD_PATH), $filename);
        }

        $data = [
            'product_id' => $request->product_id,
            'media' => $newfilename ? ProductMedia::UPLOAD_PATH . $newfilename : $filename,
            'status' => $request->status
        ];
        $productMedia->update($data);
        $productMedia->save();
        return ResponseHelper::success("Product Media Updated", $productMedia);
    }

    /**
     * destroy a product media
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $productMedia = ProductMedia::where('id', $id)->first();
        $productMedia->delete();
        return ResponseHelper::success('Product Media Deleted');
    }
}
