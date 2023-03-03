<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductVariantRepositoryInterface
{
    /**
     * get all product variant
     * @return Illuminate\Http\Response
     */
    public function all();

    /**
     * create a product variant
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request);

    /**
     * details a product variant
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function show($id);

    /**
     * update a product variant
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id);

    /**
     * destroy a product variant
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id);
}
