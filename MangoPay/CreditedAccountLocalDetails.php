<?php

namespace MangoPay;

class CreditedAccountLocalDetails extends Libraries\Dto
{
    /**
     * The name of the bank.
     * @var string
     */
    public $BankName;

    /**
     * The name of the owner of the account.
     * @var string
     */
    public $AccountOwner;

    /**
     * The address associated with the account.
     * @var AccountAddress
     */
    public $Address;

    /**
     * Local account number. Its properties depend on the account's country and may change over time,
     * so it is exposed as a map (e.g. AccountNumber, SortCode) to be read dynamically.
     * @var array<string, mixed>
     */
    public $Account;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Address'] = '\MangoPay\AccountAddress';

        return $subObjects;
    }
}
