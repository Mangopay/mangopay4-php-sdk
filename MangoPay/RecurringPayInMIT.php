<?php

namespace MangoPay;

class RecurringPayInMIT extends Libraries\Dto
{
    /**
     * @var string
     */
    public $RecurringPayinRegistrationId;

    /**
     * @var \MangoPay\Money
     */
    public $DebitedFunds;

    /**
     * @var \MangoPay\Money
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
}
