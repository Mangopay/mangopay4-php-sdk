<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class SupportedBank extends Dto
{
    /**
     * @var array<BanksByCountry>
     */
    public $Countries;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Countries'] = ['array_single', '\MangoPay\BanksByCountry'];

        return $subObjects;
    }
}
