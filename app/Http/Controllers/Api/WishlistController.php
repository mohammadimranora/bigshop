<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\WishlistRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    private WishlistRepositoryInterface $wishlistRepository;

    public function __construct(WishlistRepositoryInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->wishlistRepository->all();
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
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->wishlistRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = Wishlist::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Wishlist Item not found!");
        }
        return $this->wishlistRepository->show($id);
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
        $exists = Wishlist::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Wishlist Item not found!");
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->wishlistRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = Wishlist::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Wishlist Item not found!");
        }
        return $this->wishlistRepository->destroy($id);
    }
}
