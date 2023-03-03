<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRepository implements CategoryRepositoryInterface
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
     *      * create a category
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
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
     * update a category
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
     * destroy a category
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
