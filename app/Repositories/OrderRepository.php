<?php

namespace App\Repositories;

use App\Helpers\OrderHelper;
use App\Helpers\ResponseHelper;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $orders = Order::get();
        return ResponseHelper::success("Success", $orders);
    }

    /**
     * create a order
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', $request->user_id)->get();
        $orderNumber = OrderHelper::orderNumber();
        $total = 0;
        $discount = 0;
        $orderItemsData = [];

        if ($cartItems->count() == 0) {
            return ResponseHelper::error('No Items in the cart');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        try {
            DB::beginTransaction();
            $orderData = [
                'user_id' => $request->user_id,
                'order_number' => $orderNumber,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'PENDING',
                'status' => 'PENDING'
            ];

            $order = Order::create($orderData);

            foreach ($cartItems as $cartItem) {
                $item = [];
                $item['order_id'] = $order->id;
                $item['user_id'] = $request->user_id;
                $item['product_id'] = $cartItem->product_id;
                $item['variant_id'] = $cartItem->variant_id;
                $item['price'] = $cartItem->price;
                $item['quantity'] = $cartItem->quantity;
                array_push($orderItemsData, $item);
            }
            OrderItem::insert($orderItemsData);
            $cartItems->map->delete();
            DB::commit();
            return ResponseHelper::success('Order Created', $order, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::error('Order wasn\'t created, Error: ' . $th->getMessage());
        }
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id', $id)->get();
        return ResponseHelper::success("Order Details", $order);
    }

    /**
     * update a order
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update($request->all());
        $order->save();
        return ResponseHelper::success("Order Updated", $order);
    }

    /**
     * destroy a order
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)->first();
        $order->delete();
        return ResponseHelper::success('Order Deleted');
    }

    /**
     * get orders by user
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function getOrdersByuser($id)
    {
        $wishlists = Order::where('user_id', $id)->get();
        return ResponseHelper::success('Orders', $wishlists);
    }
}
