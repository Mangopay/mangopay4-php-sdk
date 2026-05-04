<?php

namespace MangoPay;

class InstantPayout extends Libraries\Dto
{
    /**
     * @var boolean
     */
    public $IsReachable;

    /**
     * @var FallbackReason
     */
    public $UnreachableReason;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['FallbackReason'] = '\MangoPay\FallbackReason';

        return $subObjects;
    }
}
