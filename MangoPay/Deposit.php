<?php

namespace MangoPay;

class Deposit extends Libraries\EntityBase
{
    /**
     * @var string
     */
    public $AuthorId;

    /**
     * @var Money
     */
    public $DebitedFunds;

    /**
     * @var string
     * @see DepositStatus
     */
    public $Status;

    /**
     * @var string
     * @see CardPreAuthorizationPaymentStatus
     */
    public $PaymentStatus;

    /**
     * @var PayinsLinked
     */
    public $PayinsLinked;

    /**
     * @var string
     */
    public $ResultCode;

    /**
     * @var string
     */
    public $ResultMessage;

    /**
     * @var string
     */
    public $CardId;

    /**
     * @var string
     */
    public $SecureModeReturnURL;

    /**
     * @var string
     */
    public $SecureModeRedirectURL;

    /**
     * @var boolean
     */
    public $SecureModeNeeded;

    /**
     * @var int Unix timestamp
     */
    public $ExpirationDate;

    /**
     * @var string
     */
    public $PaymentType;

    /**
     * @var string
     */
    public $ExecutionType;

    /**
     * @var string
     */
    public $StatementDescriptor;

    /**
     * @var string
     */
    public $Culture;

    /**
     * @var string
     */
    public $IpAddress;

    /**
     * BrowserInfo
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * @var Billing
     */
    public $Billing;

    /**
     * @var Shipping
     */
    public $Shipping;

    /**
     * @var string
     */
    public $Requested3DSVersion;

    /**
     * @var string
     */
    public $Applied3DSVersion;

    /**
     * Information of the card
     * @var object
     */
    public $CardInfo;

    /**
     * Authentication result.
     * @var AuthenticationResult|null
     */
    public $AuthenticationResult;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['PayinsLinked'] = '\MangoPay\PayinsLinked';
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';
        $subObjects['Billing'] = '\MangoPay\Billing';
        $subObjects['Shipping'] = '\MangoPay\Shipping';
        $subObjects['AuthenticationResult'] = '\MangoPay\AuthenticationResult';

        return $subObjects;
    }
}
