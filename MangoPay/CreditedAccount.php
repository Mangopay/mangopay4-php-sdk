<?php

namespace MangoPay;

class CreditedAccount extends Libraries\Dto
{
    /**
     * The account details in local format.
     * @var CreditedAccountLocalDetails
     */
    public $LocalAccountDetails;

    /**
     * The account details in international format.
     * @var CreditedAccountInternationalDetails
     */
    public $InternationalAccountDetails;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['LocalAccountDetails'] = '\MangoPay\CreditedAccountLocalDetails';
        $subObjects['InternationalAccountDetails'] = '\MangoPay\CreditedAccountInternationalDetails';

        return $subObjects;
    }
}
