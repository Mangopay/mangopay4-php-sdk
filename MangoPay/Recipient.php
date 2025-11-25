<?php

namespace MangoPay;

/**
 * Recipient entity
 */
class Recipient extends Libraries\EntityBase
{
    /**
     * The status
     * @var string
     */
    public $Status;

    /**
     * A unique external identifier for the recipient's bank account.
     * @var string
     */
    public $DisplayName;

    /**
     * Defines the payout method (e.g., LocalBankTransfer, InternationalBankTransfer).
     * @var string
     */
    public $PayoutMethodType;

    /**
     * Specifies whether the recipient is an Individual or a Business.
     * @var string
     */
    public $RecipientType;

    /**
     * 3-letter ISO 4217 destination currency code (e.g. EUR, USD, GBP, AUD, CAD,HKD, SGD, MXN).
     * @var string
     */
    public $Currency;

    /**
     * Country ISO
     * @var string
     */
    public $Country;

    /**
     * The scope of the recipient:
     *
     * <p>- PAYOUT – Usable for payouts and in pay-in use cases.
     * A PAYOUT recipient can only be created by a user with the UserCategory OWNER and requires SCA.
     * You need to use the returned PendingUserAction.RedirectUrl value, adding your encoded returnUrl as a
     * query parameter, to redirect the user to the hosted SCA session so they can complete the necessary steps.</p>
     *
     * <p>- PAYIN - Usable for pay-in use cases only, such as direct debit and refunds using payouts.
     * A PAYIN recipient can be created by a user with the UserCategory PAYER or OWNER, and does not require SCA.</p>
     * @var string
     */
    public $RecipientScope;

    /**
     * The unique identifier of the user.
     * @var string
     */
    public $UserId;

    /**
     * Individual recipient
     * @var IndividualRecipient
     */
    public $IndividualRecipient;

    /**
     * Business recipient
     * @var BusinessRecipient
     */
    public $BusinessRecipient;

    /**
     * Each currency has specific bank details that must be provided based on the recipient's location and payout requirements.
     * @var array<string, mixed>
     */
    public $LocalBankTransfer;

    /**
     * The account details if PayoutMethodType is InternationalBankTransfer.
     * @var array<string, mixed>
     */
    public $InternationalBankTransfer;

    /**
     * Information about the action required from the user
     * @var PendingUserAction|null
     */
    public $PendingUserAction;

    /**
     * @var VerificationOfPayee|null
     */
    public $RecipientVerificationOfPayee;

    /**
     * @var string|null
     * If provided, possible values: USER_PRESENT, USER_NOT_PRESENT.
     */
    public $ScaContext;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['IndividualRecipient'] = '\MangoPay\IndividualRecipient';
        $subObjects['BusinessRecipient'] = '\MangoPay\BusinessRecipient';
        $subObjects['PendingUserAction'] = '\MangoPay\PendingUserAction';
        $subObjects['RecipientVerificationOfPayee'] = '\MangoPay\VerificationOfPayee';

        return $subObjects;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        return $properties;
    }
}
