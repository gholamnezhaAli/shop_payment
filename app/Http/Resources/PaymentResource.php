<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "product" => new ProductResource($this->product),
            "amount" => $this->amount,
            "invoice_id" => $this->invoice_id,
            "status" => $this->status,
        ];
    }
}
