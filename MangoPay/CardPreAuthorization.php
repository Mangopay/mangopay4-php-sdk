<?php

namespace MangoPay;

/**
 * Pre-authorization entity
 */
class CardPreAuthorization extends Libraries\EntityBase
{
    /**
     * The user Id of the author of the pre-authorization
     * @var string
     */
    public $AuthorId;

    /**
     * It represents the amount debited on the bank account
     * of the Author.DebitedFunds = Fees + CreditedFunds
     * (amount received on wallet)
     * @var \MangoPay\Money
     */
    public $DebitedFunds;

    /**
     * Status of the PreAuthorization
     * @var string
     * @see \MangoPay\CardPreAuthorizationStatus
     */
    public $Status;

    /**
     * The status of the payment after the PreAuthorization
     * @var string
     * @see \MangoPay\CardPreAuthorizationPaymentStatus
     */
    public $PaymentStatus;

    /**
     * The PreAuthorization result code
     * @var string
     */
    public $ResultCode;

    /**
     * The PreAuthorization result Message explaining the result code
     * @var string
     */
    public $ResultMessage;

    /**
     * An optional value to be specified on the user's bank statement
     * @var string
     */
    public $StatementDescriptor;

    /**
     * How the PreAuthorization has been executed.
     * Only on value for now: CARD
     * @var string
     */
    public $ExecutionType;

    /**
     * The SecureMode correspond to '3D secure' for CB Visa and MasterCard
     * or 'Amex Safe Key' for American Express.
     * This field lets you activate it manually.
     * @var string
     */
    public $SecureMode;

    /**
     * The ID of the registered card (Got through CardRegistration object)
     * @var string
     */
    public $CardId;

    /**
     * Boolean. The value is 'true' if the SecureMode was used
     * @var bool
     */
    public $SecureModeNeeded;

    /**
     * This is the URL where to redirect users to proceed
     * to 3D secure validation
     * @var string
     */
    public $SecureModeRedirectURL;

    /**
     * This is the URL where users are automatically redirected
     * after 3D secure validation (if activated)
     * @var string
     */
    public $SecureModeReturnURL;

    /**
     * The date when the payment is processed
     * @var int Unix timestamp
     */
    public $ExpirationDate;

    /**
     * The date when the payment was authorized
     * @var int Unix timestamp
     */
    public $AuthorizationDate;

    /**
     * The type of pre-authorization ("CARD" is the only acceptable value at present
     * @var string
     */
    public $PaymentType;

    /**
     * The Id of the associated PayIn
     * @var string
     */
    public $PayInId;

    /**
     * Billing information
     * @var \MangoPay\Billing
     */
    public $Billing;

    /**
     * Security validation information
     * @var \MangoPay\SecurityInfo
     */
    public $SecurityInfo;

    /**
     * Boolean. The value is 'true' if the MultiCapture was used
     * @var bool
     */
    public $MultiCapture;

    /**
     * RemainingFunds
     * @var \MangoPay\Money
     */
    public $RemainingFunds;

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
     * Requested3DSVersion
     * @var string
     */
    public $Requested3DSVersion;

    /**
     * Applied3DSVersion
     * @var string
     */
    public $Applied3DSVersion;

    /**
     * Information of the card
     * @var object
     */
    public $CardInfo;

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

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'DebitedFunds' => '\MangoPay\Money',
            'Billing' => '\MangoPay\Billing',
            'SecurityInfo' => '\MangoPay\SecurityInfo',
            'RemainingFunds' => '\MangoPay\Money',
            'AuthenticationResult' => '\MangoPay\AuthenticationResult',
        ];
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'Status');
        array_push($properties, 'ResultCode');
        array_push($properties, 'ResultMessage');

        return $properties;
    }
}
