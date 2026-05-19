<?php

namespace MangoPay;

class PayInRecurringRegistrationRequestResponse extends PayInRecurringRegistration
{
    /**
     * @var string
     */
    public $RecurringType;

    /**
     * @var Money
     */
    public $TotalAmount;

    /**
     * @var int
     */
    public $CycleNumber;

    /**
     * @var int
     */
    public $FreeCycles;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['TotalAmount'] = '\MangoPay\Money';

        return $subObjects;
    }
}
