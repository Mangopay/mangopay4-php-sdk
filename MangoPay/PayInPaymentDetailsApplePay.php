<?php

namespace MangoPay;

class PayInPaymentDetailsApplePay extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Payment information returned by Apple Pay payment
     * @var PaymentData
     */
    public $PaymentData;

    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alpha-numeric and space.
     * @var string
     */
    public $StatementDescriptor;

    /**
     * Declarative marketplace information used to comply with
     * Visa Marketplace reporting.
     * @var MarketplaceData
     */
    public $MarketplaceData;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['PaymentData'] = '\MangoPay\PaymentData';
        $subObjects['MarketplaceData'] = '\MangoPay\MarketplaceData';

        return $subObjects;
    }
}
