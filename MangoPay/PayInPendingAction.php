<?php

namespace MangoPay;

class PayInPendingAction extends Libraries\Dto
{
    /**
     * The type of pending action, e.g. PAYMENT_REQUIRED.
     * @var string
     */
    public $Action;

    /**
     * Details related to the pending action, if applicable.
     * @var PayInPendingActionDetail[]
     */
    public $ActionDetails;

    /**
     * Unix timestamp (UTC) at which the pending action expires.
     * @var int
     */
    public $ExpiryDate;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['ActionDetails'] = ['array_single', '\MangoPay\PayInPendingActionDetail'];
        return $subObjects;
    }
}
