<?php

namespace MangoPay;

class RecurringPayInCIT extends Libraries\Dto
{
    /**
     * @var string
     */
    public $RecurringPayinRegistrationId;

    /**
     * @var \MangoPay\BrowserInfo
     */
    public $BrowserInfo;

    /**
     * @var string
     */
    public $IpAddress;

    /**
     * @var string
     */
    public $SecureModeReturnURL;

    /**
     * @var string
     */
    public $StatementDescriptor;

    /**
     * @var string
     */
    public $Tag;

    /**
     * @var Money
     */
    public $DebitedFunds;

    /**
     * @var Money
     */
    public $Fees;

    /**
     * @var string|null
     */
    public $PaymentCategory;
}
