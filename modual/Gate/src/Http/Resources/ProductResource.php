<?php

namespace Gate\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "link" => url("http://localhost:8000/payment/" . $this->id.'/'.$this->user->id),
            "price" => $this->price,
            "quantity" => $this->quantity,
        ];
    }
}
