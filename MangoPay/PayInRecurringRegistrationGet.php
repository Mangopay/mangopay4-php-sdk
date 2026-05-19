<?php

namespace MangoPay;

class PayInRecurringRegistrationGet extends PayInRecurringRegistration
{
    /**
     * @var RecurringPayInCurrentState
     */
    public $CurrentState;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['CurrentState'] = '\MangoPay\RecurringPayInCurrentState';

        return $subObjects;
    }
}
