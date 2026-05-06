<?php

namespace MangoPay;

class PayInIntentSplitInfo extends Libraries\Dto
{
    /**
     * Unique identifier.
     * @var string
     */
    public $Id;

    /**
     * The date at which the object was created
     * @var int
     */
    public $CreationDate;

    /**
     * The date at which the object was successfully moved to CREATED
     * @var int
     */
    public $ExecutionDate;

    /**
     * The split amount
     * @var int
     */
    public $Amount;

    /**
     * The status of the split
     * @var string
     */
    public $Status;

    /**
     * Information about the items captured in the transaction.
     * @var PayInIntentLineItem[]
     */
    public $LineItems;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['LineItems'] = ['array_single', '\MangoPay\PayInIntentLineItem'];

        return $subObjects;
    }
}
