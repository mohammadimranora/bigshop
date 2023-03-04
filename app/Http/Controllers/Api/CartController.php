<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CartRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->cartRepository->all();
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
            'variant_id' => 'required|exists:product_variants,id',
            'price' => 'required|numeric|between:0,9999999999.99',
            'quantity' => 'required|numeric|between:0,9999999999',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->cartRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = Cart::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Cart Item not found!");
        }
        return $this->cartRepository->show($id);
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
        $exists = Cart::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Cart Item not found!");
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'price' => 'required|numeric|between:0,9999999999.99',
            'quantity' => 'required|numeric|between:0,9999999999',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->cartRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = Cart::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Cart Item not found!");
        }
        return $this->cartRepository->destroy($id);
    }

    /**
     * get wishlist items by user
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getCartItemsByUser($id)
    {
        $exists = User::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("User not found!");
        }

        return $this->cartRepository->getCartItemsByUser($id);
    }
}
