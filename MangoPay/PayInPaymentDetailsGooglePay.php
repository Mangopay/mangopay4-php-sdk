<?php

namespace MangoPay;

class PayInPaymentDetailsGooglePay extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Payment information returned by Google Pay payment
     * @var string
     */
    public $PaymentData;

    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alpha-numeric and space.
     * @var string
     */
    public $StatementDescriptor;

    /// V2 ///

    /**
     * Information about the browser used by the end user (author)
     * to perform the payment.
     * @return string
     */
    public $IpAddress;

    /**
     * The IP address of the end user initiating the transaction,
     * in IPV4 or IPV6 format.
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * Information about the end user shipping address.
     * @var Shipping
     */
    public $Shipping;

    /**
     * Return URL
     * @var string
     */
    public $ReturnURL;

    /**
     * Declarative marketplace information used to comply with
     * Visa Marketplace reporting.
     * @var MarketplaceData
     */
    public $MarketplaceData;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';
        $subObjects['Shipping'] = '\MangoPay\Shipping';
        $subObjects['MarketplaceData'] = '\MangoPay\MarketplaceData';

        return $subObjects;
    }
}
