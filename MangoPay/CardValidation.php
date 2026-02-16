<?php

namespace MangoPay;

class CardValidation extends Libraries\EntityBase
{
    /**
     * Author Id
     * @var string
     */
    public $AuthorId;

    /**
     * This is the URL where users are automatically redirected
     * after 3D secure validation (if activated)
     * @var string
     */
    public $SecureModeReturnUrl;

    /**
     * SecureModeRedirectURL
     * @var string
     */
    public $SecureModeRedirectURL;

    /**
     * Boolean. The value is 'true' if the SecureMode was used
     * @var bool
     */
    public $SecureModeNeeded;

    /**
     * The mode applied for the 3DS2 protocol for CB, Visa, and Mastercard
     * @var string
     */
    public $SecureMode;

    /**
     * Ip Address
     * @var string
     */
    public $IpAddress;

    /**
     * BrowserInfo
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * Validity. For allowed values, see constants in MangoPay\CardValidity
     * @var string
     */
    public $Validity;

    /**
     * @var string
     * @see \MangoPay\TransactionType
     */
    public $Type;

    /**
     * Applied3DSVersion
     * @var string
     */
    public $Applied3DSVersion;

    /**
     * The current status of the card validation
     * @var string
     * @see \MangoPay\CardValidationStatus
     */
    public $Status;

    /**
     * The mandate result code
     * @var string
     */
    public $ResultCode;

    /**
     * The mandate result Message
     * @var string
     */
    public $ResultMessage;


    /**
     * Allowed values: VISA, MASTERCARD, CB, MAESTRO
     *
     * The card network to use, as chosen by the cardholder, in case of co-branded card products.
     * @var string
     */
    public $PreferredCardNetwork;

    /**
     * The date and time at which successful authorization occurred. If authorization failed, the value is null.
     * @var int
     */
    public $AuthorizationDate;

    /**
     * Information of the card
     * @var CardInfo
     */
    public $CardInfo;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */

    /**
     * Allowed values: ECommerce (default), TelephoneOrder
     *
     * The channel through which the user provided their card details, used to indicate mail-order and telephone-order (MOTO) payments.
     * @var string
     */
    public $PaymentCategory;

    /**
     * Authentication result.
     * @var AuthenticationResult|null
     */
    public $AuthenticationResult;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';
        $subObjects['AuthenticationResult'] = '\MangoPay\AuthenticationResult';

        return $subObjects;
    }
}
