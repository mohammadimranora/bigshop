<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\WishlistRepositoryInterface;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistRepository implements WishlistRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $wishlist = Wishlist::all();
        return ResponseHelper::success("Success", $wishlist);
    }

    /**
     * create a wishlist
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wishlist = Wishlist::where($request->all())->exists();
        if ($wishlist) {
            return ResponseHelper::success('Wishlist Item Already Existed');
        }
        $wishlist = Wishlist::create($request->all());
        return ResponseHelper::success('Wishlist Item Created', $wishlist, 201);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $wishlist = Wishlist::find($id);
        return ResponseHelper::success("Wishlist Item Details", $wishlist);
    }

    /**
     * update a wishlist
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::find($id);
        $wishlist->update($request->all());
        $wishlist->save();
        return ResponseHelper::success("Wishlist Item Updated", $wishlist);
    }

    /**
     * destroy a wishlist
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)->first();
        $wishlist->delete();
        return ResponseHelper::success('Wishlist Item Deleted');
    }
}
