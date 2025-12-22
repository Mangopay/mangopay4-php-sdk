<?php

namespace MangoPay;

class PayInIntent extends Libraries\EntityBase
{
    /**
     * An amount of money in the smallest sub-division of the currency
     * @var int
     */
    public $Amount;

    /**
     * The remaining amount on the intent available for transfers
     * @var int
     */
    public $AvailableAmountToSplit;

    /**
     * The currency of the funds
     * @var string
     */
    public $Currency;

    /**
     * Information about the fees
     * @var int
     */
    public $PlatformFeesAmount;

    /**
     * The status of the intent
     * @var string
     */
    public $Status;

    /**
     * The possible next statuses for the intent
     * @var string
     */
    public $NextActions;

    /**
     * Information about the external processed transaction
     * @var PayInIntentExternalData
     */
    public $ExternalData;

    /**
     * Information about the buyer
     * @var PayInIntentBuyer
     */
    public $Buyer;

    /**
     * Information about the items purchased in the transaction.
     * The total of all LineItems UnitAmount, TaxAmount, DiscountAmount, TotalLineItemAmount must equal the Amount.
     * The total of all LineItems FeesAmount mus equal the PlatformFees amount.
     * @var PayInIntentLineItem[]
     */
    public $LineItems;

    /**
     * Information about the amounts captured against the intent
     * @var PayInIntentCapture[]
     */
    public $Captures;

    /**
     * @var PayInIntentCapture
     */
    public $Capture;

    /**
     * Information about the amounts refunded against the intent
     * @var PayInIntentRefund[]
     */
    public $Refunds;

    /**
     * @var PayInIntentRefund | null
     */
    public $Refund;

    /**
     * Information about the amounts refunded against the intent
     * @var PayInIntentDispute[]
     */
    public $Disputes;

    /**
     * @var PayInIntentDispute
     */
    public $Dispute;

    /**
     * Information about the amounts split against the intent
     * @var PayInIntentSplitInfo[]
     */
    public $Splits;

    /**
     * The unique identifier of the settlement linked to this intent in Mangopay ecosystem
     * @var string
     */
    public $SettlementId;
    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ExternalData'] = '\MangoPay\PayInIntentExternalData';
        $subObjects['Buyer'] = '\MangoPay\PayInIntentBuyer';

        return $subObjects;
    }
}
