<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\OrderItemRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    private OrderItemRepositoryInterface $orderItemRepository;

    public function __construct(OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->orderItemRepository->all();
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
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'price' => 'required|numeric|between:0,9999999999.99',
            'quantity' => 'required|numeric|between:0,9999999999'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->orderItemRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = OrderItem::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order Item not found!");
        }
        return $this->orderItemRepository->show($id);
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
        $exists = OrderItem::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order Item not found!");
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'price' => 'required|numeric|between:0,9999999999.99',
            'quantity' => 'required|numeric|between:0,9999999999'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->orderItemRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = OrderItem::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order Item not found!");
        }
        return $this->orderItemRepository->destroy($id);
    }

    /**
     * return the order items by order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderItemByOrder($orderId)
    {
        $exists = Order::where('id', $orderId)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order not found!");
        }

        return $this->orderItemRepository->getOrderItemByOrder($orderId);
    }
}
