<?php

namespace MangoPay;

class UserBlockStatus extends Libraries\EntityBase
{
    /**
     * @var ScopeBlocked
     */
    public $ScopeBlocked;

    /**
     * @var string
     */
    public $ActionCode;

    /**
     * @var KycInformation
     */
    public $KycInformation;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ScopeBlocked'] = '\MangoPay\ScopeBlocked';
        $subObjects['KycInformation'] = '\MangoPay\KycInformation';

        return $subObjects;
    }
}
