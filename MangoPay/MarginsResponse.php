<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class MarginsResponse extends Dto
{
    /**
     * @var UserMargin
     */
    public $Mangopay;

    /**
     * @var UserMargin|null
     */
    public $User;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Mangopay'] = '\MangoPay\UserMargin';
        $subObjects['User'] = '\MangoPay\UserMargin';

        return $subObjects;
    }
}
