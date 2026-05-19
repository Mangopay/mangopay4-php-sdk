<?php

namespace MangoPay;

class LocalAccountDetails extends Libraries\Dto
{
    /**
     * Information about the address associated with the local IBAN account.
     * @var VirtualAccountAddress
     */
    public $Address;

    /**
     * Information about the address associated with the local IBAN account.
     * @var LocalAccount
     */
    public $Account;

    /**
     * The bank name
     * @var string
     */
    public $BankName;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Address'] = '\MangoPay\VirtualAccountAddress';
        $subObjects['Account'] = '\MangoPay\LocalAccount';

        return $subObjects;
    }
}
