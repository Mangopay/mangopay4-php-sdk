<?php

namespace MangoPay;

class ReconciliationDetails extends Libraries\Dto
{
    /**
     * The amount matched between the DeclaredDebitedFunds and the ReceivedFunds.
     * Null for a pay-in to a Virtual Account.
     * @var Money
     */
    public $MatchedFunds;

    /**
     * The amount received on Mangopay's bank account. Null for a pay-in to a Virtual Account.
     * @var Money
     */
    public $ReceivedFunds;

    /**
     * The wire reference received with the incoming bank wire.
     * @var string
     */
    public $ReceivedWireReference;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['MatchedFunds'] = '\MangoPay\Money';
        $subObjects['ReceivedFunds'] = '\MangoPay\Money';

        return $subObjects;
    }
}
