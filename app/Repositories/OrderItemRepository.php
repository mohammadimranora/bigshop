<?php

namespace App\Repositories;

use App\Helpers\OrderHelper;
use App\Helpers\ResponseHelper;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $ordersItems = OrderItem::get();
        return ResponseHelper::success("Success", $ordersItems);
    }

    /**
     * create a order item
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderItem = OrderItem::create($request->all());
        return ResponseHelper::success('Order Item Created', $orderItem);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = OrderItem::where('id', $id)->get();
        return ResponseHelper::success("Order Item Details", $order);
    }

    /**
     * update a order item
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);
        $orderItem->update($request->all());
        $orderItem->save();
        return ResponseHelper::success("Order Item Updated", $orderItem);
    }

    /**
     * destroy a order item
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::where('id', $id)->first();
        $orderItem->delete();
        return ResponseHelper::success('Order Item Deleted');
    }

    /**
     * get order item by order
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function getOrderItemByOrder($id)
    {
        $wishlists = OrderItem::where('order_id', $id)->get();
        return ResponseHelper::success('Order Items', $wishlists);
    }
}
