<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductUserRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Product::query();
    }

    public function find($productId)
    {

        return $this->query->find($productId);

    }

    public function getProductPrice($productId)
    {

        return $this->query->find($productId)->price;

    }

    public function getProducts()
    {

        return $this->query->paginate(5);

    }

    public function newProduct($request)
    {

        $this->query->create([
            "user_id" => auth()->id(),
            "name" => $request->name,
            "slug" => $request->slug,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
        ]);

    }

}
