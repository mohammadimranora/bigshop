<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface WishlistRepositoryInterface
{
    /**
     * get all wishlists
     * @return Illuminate\Http\Response
     */
    public function all();

    /**
     * create a wishlist
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request);

    /**
     * details a wishlist
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function show($id);

    /**
     * update a wishlist
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id);

    /**
     * destroy a wishlist
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id);
}
