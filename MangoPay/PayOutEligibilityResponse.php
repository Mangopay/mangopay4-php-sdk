<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class PayOutEligibilityResponse extends Dto
{
    /**
     * @var InstantPayout
     */
    public $InstantPayout;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['InstantPayout'] = '\MangoPay\InstantPayout';

        return $subObjects;
    }
}
