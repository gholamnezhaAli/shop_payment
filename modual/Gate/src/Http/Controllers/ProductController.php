<?php

namespace Gate\Http\Controllers;


use App\Http\Resources\ProductResource;
use Gate\Facade\ProductUserFacade;
use Gate\Repositories\ProductUserRepo;
use Illuminate\Http\Request;

class ProductController extends ApiController
{


    public function index()
    {
        $products = ProductUserFacade::getProducts();

        return $this->successResponse(200, [
            "products" => ProductResource::collection($products),
            "meta" => ProductResource::collection($products)->response()->getData()->meta,
            "links" => ProductResource::collection($products)->response()->getData()->links,
        ], "get products successfully");
    }


    public function store(Request $request)
    {

        ProductUserFacade::newProduct($request);
        $products = ProductUserFacade::getProducts();

        return $this->successResponse(201, [
            "products" => ProductResource::collection($products),
        ], "product created successfully");
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
