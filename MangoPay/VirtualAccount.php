<?php

namespace MangoPay;

/**
 * Virtual Account entity
 */
class VirtualAccount extends Libraries\EntityBase
{
    /**
     * The ID of the wallet
     * @var string
     */
    public $WalletId;

    /**
     * The credited user ID
     * @var string
     */
    public $CreditedUserId;

    /**
     * The type of the virtual account
     * Allowed values: `COLLECTION`, `USER_OWNED`
     * @var string
     * @see \MangoPay\VirtualAccountPurpose
     */
    public $VirtualAccountPurpose;

    /**
     * The country of the IBAN. The country must correspond to the currency of the wallet
     * ISO 3166-1 alpha-2 format is expected
     * @var string
     */
    public $Country;

    /**
     * The status of the virtual account creation
     * Allowed values: `COLLECTION`, `USER_OWNED`
     * @var string
     * @see \MangoPay\VirtualAccountStatus
     */
    public $Status;

    /**
     * Whether the banking alias is active or not
     * @var bool
     */
    public $Active;

    /**
     * The current Status of the Virtual Account
     * Allowed values: `COLLECTION`, `USER_OWNED`
     * @var string
     * @see \MangoPay\VirtualAccountOwner
     */
    public $AccountOwner;

    /**
     * The current Status of the Virtual Account
     * @var \MangoPay\LocalAccountDetails
     */
    public $LocalAccountDetails;

    /**
     * The current Status of the Virtual Account
     * @var \MangoPay\InternationalAccountDetails[]
     */
    public $InternationalAccountDetails;

    /**
     * The current Status of the Virtual Account
     * @var \MangoPay\VirtualAccountCapabilities
     */
    public $Capabilities;

    /**
     * Result code
     * @var string
     */
    public $ResultCode;

    /**
     * Result message
     * @var string
     */
    public $ResultMessage;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['LocalAccountDetails'] = '\MangoPay\LocalAccountDetails';
        $subObjects['InternationalAccountDetails'] = ['array_single', '\MangoPay\InternationalAccountDetails'];
        $subObjects['Capabilities'] = '\MangoPay\VirtualAccountCapabilities';

        return $subObjects;
    }
}
