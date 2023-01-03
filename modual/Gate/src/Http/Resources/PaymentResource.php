<?php

namespace Gate\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "product" => new ProductResource($this->product),
            "amount" => $this->amount,
            "token" => $this->token,
            "status" => $this->status,
        ];
    }
}
