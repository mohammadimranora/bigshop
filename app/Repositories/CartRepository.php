<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartRepository implements CartRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $wishlist = Cart::with(['user', 'product', 'variant'])->get();
        return ResponseHelper::success("Success", $wishlist);
    }

    /**
     * create a cart
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wishlist = Cart::where($request->all())->exists();
        if ($wishlist) {
            return ResponseHelper::success('Cart Item Already Existed');
        }
        $wishlist = Cart::create($request->all());
        return ResponseHelper::success('Cart Item Created', $wishlist, 201);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $wishlist = Cart::with(['user', 'product', 'variant'])->where('id', $id)->get();
        return ResponseHelper::success("Cart Item Details", $wishlist);
    }

    /**
     * update a cart
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $wishlist = Cart::find($id);
        $wishlist->update($request->all());
        $wishlist->save();
        return ResponseHelper::success("Cart Item Updated", $wishlist);
    }

    /**
     * destroy a cart
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $wishlist = Cart::where('id', $id)->first();
        $wishlist->delete();
        return ResponseHelper::success('Cart Item Deleted');
    }

    /**
     * destroy a cart
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function getCartItemsByUser($id)
    {
        $wishlists = Cart::with(['user', 'product', 'variant'])->where('user_id', $id)->get();
        return ResponseHelper::success('Cart Items', $wishlists);
    }
}
