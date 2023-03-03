<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\WishlistRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class WishlistRepository implements WishlistRepositoryInterface
{
    /**
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $categories = Category::with(['parent', 'children'])->get();
        return ResponseHelper::success("Success", $categories);
    }

    /**
     * create a wishlist
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return ResponseHelper::success('Category Created', $category, 201);
    }

    /**
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id', $id)->with(['parent', 'children'])->first();
        return ResponseHelper::success("Category Details", $category);
    }

    /**
     * update a wishlist
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->with(['parent', 'children'])->first();
        $category->update($request->all());
        $category->save();
        return ResponseHelper::success("Category Updated", $category);
    }

    /**
     * destroy a wishlist
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();
        $category->delete();
        return ResponseHelper::success('Category Deleted');
    }
}
