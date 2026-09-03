<?php

namespace MangoPay;

/**
 * Class represents BankWire type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsBankWire extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Declared debited funds
     * @var Money
     */
    public $DeclaredDebitedFunds;

    /**
     * Declared fees
     * @var Money
     */
    public $DeclaredFees;

    /**
     * Bank account details
     * @var BankAccount
     */
    public $BankAccount;

    /**
     * Wire reference
     * @var string
     */
    public $WireReference;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'DeclaredDebitedFunds' => '\MangoPay\Money' ,
            'DeclaredFees' => '\MangoPay\Money' ,
            'BankAccount' => '\MangoPay\BankAccount'
        ];
    }
}
