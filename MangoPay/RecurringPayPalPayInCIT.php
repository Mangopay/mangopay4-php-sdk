<?php

namespace MangoPay;

class RecurringPayPalPayInCIT extends Libraries\Dto
{
    /**
     * The unique identifier of the recurring pay-in registration.
     * @var string
     */
    public $RecurringPayinRegistrationId;

    /**
     * Custom data that you can add to this object.
     * @var string
     */
    public $Tag;

    /**
     * The URL to which the user is returned after the payment, whether the transaction is successful or not.
     * @var string
     */
    public $ReturnURL;

    /**
     * The URL to which the user is returned after canceling the payment.
     * If not provided, the Cancel button returns the user to the RedirectURL.
     * @var string
     */
    public $CancelURL;

    /**
     * Custom description to appear on the user’s bank statement along with the platform name
     * @var string
     */
    public $StatementDescriptor;

    /**
     * Information about the end user’s shipping address, managed by ShippingPreference.
     *
     * Required if ShippingPreference is SET_PROVIDED_ADDRESS and the shipping information is not present in the
     * recurring registration object.
     * @var Shipping
     */
    public $Shipping;

    /**
     * Information about the items purchased in the transaction
     * @var array
     */
    public $LineItems;

    /**
     * The language in which the PayPal payment page is to be displayed.
     * @var string
     */
    public $Culture;

    /**
     * Information about the shipping address behavior on the PayPal payment page:
     *
     * SET_PROVIDED_ADDRESS - The Shipping parameter becomes required and its values are displayed to the end user, who is not able to modify them.
     *
     * GET_FROM_FILE – The Shipping parameter is ignored and the end user can choose from registered addresses.
     *
     * NO_SHIPPING – No shipping address section is displayed.
     *
     * @var ShippingPreference
     */
    public $ShippingPreference;

    /**
     * The platform’s order reference for the transaction.
     * @var string
     */
    public $Reference;

    /**
     * @var string|null
     */
    public $DataCollectionId;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Shipping'] = '\MangoPay\Shipping';

        return $subObjects;
    }
}
