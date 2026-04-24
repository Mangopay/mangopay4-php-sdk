<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class BanksByCountry extends Dto
{
    /**
     * @var array<Bank>
     */
    public $Banks;

    /**
     * @var string
     */
    public $Country;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Banks'] = ['array_single', '\MangoPay\Bank'];

        return $subObjects;
    }
}
