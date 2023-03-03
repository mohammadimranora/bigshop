<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductMediaRepositoryInterface
{
    /**
     * get all categories
     * @return Illuminate\Http\Response
     */
    public function all();

    /**
     * create a category
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request);

    /**
     * details a category
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function show($id);

    /**
     * update a category
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id);

    /**
     * destroy a category
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id);
}
