<?php

namespace MangoPay;

/**
 * Class represents BankWire type for mean of payment in PayOut entity
 */
class PayOutPaymentDetailsBankWire extends Libraries\Dto implements PayOutPaymentDetails
{
    /**
     * Bank account identifier
     * Null if $RecipientId is provided
     * @var string|null
     */
    public $BankAccountId;

    /**
     * Recipient identifier
     * Null if $BankAccountId is provided
     * @var string|null
     */
    public $RecipientId;

    /**
     * A custom reference you wish to appear on the user’s bank statement
     * @var string
     */
    public $BankWireRef;

    /**
     * The PaymentRef must be sent on payouts that are reimbursing bank wire pay-ins and pay-ins to virtual IBANs,
     * @var PayOutPaymentRef
     */
    public $PaymentRef;

    /**
     * The parameter "PayoutModeRequested" can have different values : "STANDARD", "INSTANT_PAYMENT",
     * "INSTANT_PAYMENT_ONLY", "RTGS_PAYMENT
     *
     * @var string
     */
    public $PayoutModeRequested;

    /**
     * Returned ModeRequested.
     * @var string
     */
    public $ModeRequested;

    /**
     * The new parameter is the current status of the mode above.
     * @var string
     */
    public $ModeApplied;

    /**
     * The fallback reason.
     * @var FallbackReason
     */
    public $FallbackReason;

    /**
     * The status.
     * @var string
     */
    public $Status;

    /**
     * @var VerificationOfPayee|null
     */
    public $RecipientVerificationOfPayee;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['PaymentRef'] = '\MangoPay\PayOutPaymentRef';
        $subObjects['FallbackReason'] = '\MangoPay\FallbackReason';
        $subObjects['RecipientVerificationOfPayee'] = '\MangoPay\VerificationOfPayee';

        return $subObjects;
    }
}
