<?php

namespace App\Http\Controllers;


use App\Http\Resources\ProductResource;
use App\Repositories\ProductUserRepo;
use Illuminate\Http\Request;

class ProductController extends ApiController
{


    public function index(ProductUserRepo $productUserRepo)
    {
        $products = $productUserRepo->getProducts();
        return $this->successResponse(200, [
            "products" => ProductResource::collection($products),
            "meta" => ProductResource::collection($products)->response()->getData()->meta,
            "links" => ProductResource::collection($products)->response()->getData()->links,
        ], "get products successfully");
    }


    public function store(ProductUserRepo $productUserRepo, Request $request)
    {

        return "aaaaaaa";
        $productUserRepo->newProduct($request);
        $products = $productUserRepo->getProducts();
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
