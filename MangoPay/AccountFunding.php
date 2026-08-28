<?php

namespace MangoPay;

class AccountFunding extends Libraries\Dto
{
    /**
     * @var \MangoPay\AccountFundingSender
     */
    public $Sender;

    /**
     * @var string
     */
    public $Purpose;

    /**
     * @var string
     */
    public $Type;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Sender'] = '\MangoPay\AccountFundingSender';

        return $subObjects;
    }
}
