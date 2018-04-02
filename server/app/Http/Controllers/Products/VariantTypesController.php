<?php

namespace App\Http\Controllers\Products;

use App\Models\Product\VariantType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\VariantType as VariantTypeRequest;
use App\Http\Resources\Product\VariantType as VariantTypeResource;

class VariantTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = VariantType::paginate();

        return VariantTypeResource::collection($query);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     * @param  VariantType  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(VariantType $type)
    {
        $type->delete();

        return response('oka');
    }
}
