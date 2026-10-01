<?php

namespace MangoPay;

/**
 * @deprecated in favor of ExtendedPreauthorization, which is used for both update and return
 */
class UpdateDeposit extends Libraries\Dto
{
    /**
     * @var string
     * @see CardPreAuthorizationPaymentStatus
     */
    public $PaymentStatus;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return parent::GetSubObjects();
    }
}
