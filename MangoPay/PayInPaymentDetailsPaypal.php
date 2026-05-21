<?php

namespace MangoPay;

/**
 * Class represents PayPal type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsPaypal extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Address used instead of the user's PayPal account address.
     * @var ShippingAddress
     * @deprecated This property will be removed in the future due to the introduction of a new way to create PayPal PayIns
     */
    public $ShippingAddress;


    /// V2 ///

    /**
     * PayPal buyer's email account
     * @var string
     */
    public $PaypalBuyerAccountEmail;

    /**
     * Custom description of the payment shown to the consumer when making payments and on the bank statement
     * @var string
     */
    public $StatementDescriptor;

    /**
     * User’s shipping address When not provided, the default address is the one register one the buyer PayPal account
     * @var Shipping
     */
    public $Shipping;

    /**
     * Information about the items bought by the customer
     * @var array
     */
    public $LineItems;

    /**
     * User’s shipping preference
     * @var ShippingPreference
     */
    public $ShippingPreference;

    /**
     * @var string
     */
    public $Reference;

    /**
     * @var string
     */
    public $CancelURL;

    /**
     * @var string
     */
    public $PaypalPayerID;

    /**
     * @var string
     */
    public $BuyerCountry;

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
    public $PaypalOrderID;

    /**
     * @var array
     */
    public $Trackings;

    /**
     * @var string|null
     */
    public $DataCollectionId;


    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ShippingAddress'] = '\MangoPay\ShippingAddress';
        $subObjects['Shipping'] = '\MangoPay\Shipping';

        return $subObjects;
    }
}
