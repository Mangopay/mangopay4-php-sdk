<?php

namespace MangoPay;

class CreditedAccountInternationalDetails extends Libraries\Dto
{
    /**
     * The owner of the account.
     * @var string
     */
    public $AccountOwner;

    /**
     * The name of the bank.
     * @var string
     */
    public $BankName;

    /**
     * The international account number.
     * @var InternationalAccount
     */
    public $Account;

    /**
     * The address associated with the account.
     * @var AccountAddress
     */
    public $Address;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Account'] = '\MangoPay\InternationalAccount';
        $subObjects['Address'] = '\MangoPay\AccountAddress';

        return $subObjects;
    }
}
