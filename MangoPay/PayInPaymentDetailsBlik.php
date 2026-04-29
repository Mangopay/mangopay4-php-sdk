<?php

namespace MangoPay;

class PayInPaymentDetailsBlik extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;


    /// Blik with code: ///

    /**
     * The 6-digit code from the user’s banking application.
     * Required when creating a Blik PayIn with code.
     * @var string
     */
    public $Code;

    /**
     * Information about the browser used by the end user (author) to perform the payment.
     * Required when creating a Blik PayIn with code.
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * The IP address of the end user initiating the transaction, in IPV4 or IPV6 format.
     * Required when creating a Blik PayIn with code.
     * @var string
     */
    public $IpAddress;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';

        return $subObjects;
    }
}
