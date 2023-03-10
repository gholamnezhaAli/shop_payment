<?php

namespace App\Repositories;

use App\Models\Card;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CardRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Card::query();
    }

    public function getCard($cardNumber, $cvv2)
    {

        return $this->query->where("card_number", $cardNumber)->where("cvv2", $cvv2)->first();
    }

    public function getCardInventory($cardNumber, $cvv2)
    {

        return $this->getCard($cardNumber, $cvv2)->inventory;
    }


}
