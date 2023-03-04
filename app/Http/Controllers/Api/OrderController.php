<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->orderRepository->all();
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
            'payment_method' => 'required|in:ONLINE,COD'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->orderRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exists = Order::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order not found!");
        }
        return $this->orderRepository->show($id);
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
        $exists = Order::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order not found!");
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:ONLINE,COD',
            'payment_status' => 'required|in:PENDING,CONFIRMED',
            'status' => 'required|in:PENDING,CONFIRMED,PROCESSING,COMPLETED'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->orderRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = Order::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("Order not found!");
        }

        return $this->orderRepository->destroy($id);
    }

    /**
     * return all orders for a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getOrdersByuser($id)
    {
        $exists = User::where('id', $id)->exists();
        if (!$exists) {
            return ResponseHelper::error("User not found!");
        }

        return $this->orderRepository->getOrdersByuser($id);
    }
}
