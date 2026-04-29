<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class RecurringPayInCurrentState extends Dto
{
    /**
     * @var integer
     */
    public $PayinsLinked;

    /**
     * @var Money
     */
    public $CumulatedDebitedAmount;

    /**
     * @var Money
     */
    public $CumulatedFeesAmount;

    /**
     * @var string
     */
    public $LastPayinId;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['CumulatedDebitedAmount'] = '\MangoPay\Money';
        $subObjects['CumulatedFeesAmount'] = '\MangoPay\Money';

        return $subObjects;
    }
}
