<?php

namespace Gate\Repositories;

use Gate\Models\Card;
use Gate\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PaymentRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Payment::query();
    }

    public function newPayment($productId, $userId)
    {
        $productRepo = new ProductUserRepo;

        $amount = $productRepo->getProductPrice($productId);
        $invoice_id = Carbon::now()->microsecond;
        $status = Payment::STATUS_SUCCESS;

        $this->query->create([
            "user_id" => $userId,
            "product_id" => $productId,
            "amount" => $amount,
            "invoice_id" => $invoice_id,
            "status" => $status,
        ]);

    }

    public function getPayments()
    {

        return $this->query->get();

    }

    public function getUserPayment()
    {

        return $this->query->where("user_id", auth()->id())->get();

    }


}
