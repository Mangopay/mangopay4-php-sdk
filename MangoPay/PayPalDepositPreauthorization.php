<?php

namespace MangoPay;

class PayPalDepositPreauthorization extends Deposit
{
    /**
     * @var string
     */
    public $PaypalPayerID;

    /**
     * @var string
     */
    public $PaypalOrderID;

    /**
     * @var string
     */
    public $BuyerFirstname;

    /**
     * @var string
     */
    public $BuyerLastname;

    /**
     * @var string
     */
    public $BuyerPhone;

    /**
     * @var string
     */
    public $BuyerCountry;

    /**
     * @var string
     */
    public $PaypalBuyerAccountEmail;

    /**
     * @var string
     */
    public $CancelURL;

    /**
     * @var PayPalWebTracking[]
     */
    public $Trackings;

    /**
     * @var ShippingPreference
     */
    public $ShippingPreference;

    /**
     * @var string
     */
    public $Reference;

    /**
     * @var LineItem[]
     */
    public $LineItems;

    /**
     * @var string
     */
    public $RedirectURL;

    /**
     * @var string
     */
    public $ReturnURL;

    /**
     * @var string
     */
    public $DataCollectionId;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Trackings'] = ['array_single', '\MangoPay\PayPalWebTracking'];
        $subObjects['LineItems'] = ['array_single', '\MangoPay\LineItem'];

        return $subObjects;
    }
}
