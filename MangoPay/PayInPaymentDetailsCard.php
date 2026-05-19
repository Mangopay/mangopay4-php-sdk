<?php

namespace MangoPay;

/**
 * Class represents Card type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsCard extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * CardType { CB_VISA_MASTERCARD, AMEX }
     * @var string
     */
    public $CardType;

    /**
     * CardId
     * @var string
     */
    public $CardId;

    /**
     * StatementDescriptor
     * @var string
     */
    public $StatementDescriptor;

    /**
     * IpAddress
     * @var string
     */
    public $IpAddress;

    /**
     * BrowserInfo
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * Shipping
     * @var Shipping
     */
    public $Shipping;

    /**
     * @var string
     */
    public $Reference;

    /**
     * @var string
     */
    public $Bic;

    /**
     * @var string
     */
    public $BankName;

    /**
     * Information of the card
     * @var object
     */
    public $CardInfo;

    /**
     * Allowed values: VISA, MASTERCARD, CB, MAESTRO
     *
     * The card network to use, as chosen by the cardholder, in case of co-branded card products.
     * @var string
     */
    public $PreferredCardNetwork;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';
        $subObjects['Shipping'] = '\MangoPay\Shipping';

        return $subObjects;
    }
}
