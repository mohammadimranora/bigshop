<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductMediaRepositoryInterface
{
    /**
     * get all medias
     * @return Illuminate\Http\Response
     */
    public function all();

    /**
     * create a media
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request);

    /**
     * details a media
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function show($id);

    /**
     * update a media
     * @param Illuminate\Http\Request
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function update(Request $request, $id);

    /**
     * destroy a media
     * @param integer $id
     * @return Illuminate\Http\Response 
     */
    public function destroy($id);
}
