<?php

namespace Gate\Repositories;

use Gate\Models\Card;


class CardRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Card::query();
    }

    public function getCard($cardNumber, $cvv2)
    {

        return $this->query
            ->where("card_number", $cardNumber)
            ->where("cvv2", $cvv2)
            ->with("user")
            ->first();
    }

    public function getCardInventory($cardNumber, $cvv2)
    {

        return $this->getCard($cardNumber, $cvv2)->inventory;
    }

    public function reduceCardInventory($cardNumber, $cvv2 ,$productPrice)
    {
        $card = $this->getCard($cardNumber, $cvv2);



        $card->update([

            "inventory"=> ($card->inventory - $productPrice)

        ]);
    }


}
