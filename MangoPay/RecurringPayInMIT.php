<?php

namespace MangoPay;

class RecurringPayInMIT extends Libraries\Dto
{
    /**
     * @var string
     */
    public $RecurringPayinRegistrationId;

    /**
     * @var Money
     */
    public $DebitedFunds;

    /**
     * @var Money
     */
    public $Fees;

    /**
     * @var string
     */
    public $StatementDescriptor;

    /**
     * @var string
     */
    public $Tag;

    /**
     * @var string|null
     */
    public $PaymentCategory;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['Fees'] = '\MangoPay\Money';

        return $subObjects;
    }
}
