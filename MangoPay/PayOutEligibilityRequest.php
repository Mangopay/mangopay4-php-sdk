<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class PayOutEligibilityRequest extends Dto
{
    /**
     * A user's ID
     * @var string
     */
    public $AuthorId;

    /**
     * Information about the funds that are being debited
     * @var Money
     */
    public $DebitedFunds;

    /**
     * Information about the fees that were taken by the client for this transaction (and were hence transferred to the Client's platform wallet)
     * @var Money
     */
    public $Fees;

    /**
     * An ID of a Bank Account
     * @var string
     */
    public $BankAccountId;

    /**
     * The ID of the wallet that was debited
     * @var string
     */
    public $DebitedWalletId;

    /**
     * A custom reference you wish to appear on the user’s bank statement (your Client Name is already shown). We advise you not to add more than 12 characters.
     * @var string
     */
    public $BankWireRef;

    /**
     * Payout mode requested. May take one of the following values:
     * STANDARD (value by default if no parameter is sent): a standard bank wire is requested and the processing time of the funds is about 48 hours;
     * INSTANT_PAYMENT: an instant payment bank wire is requested and the processing time is within 25 seconds (subject to prerequisites);
     * INSTANT_PAYMENT_ONLY: an instant payment bank wire is requested and the processing time is within 25 seconds, but if any prerequisite is not met or another problem occurs, there is no fallback: the wallet is automatically refunded and the payout is not completed.
     * @var string
     */
    public $PayoutModeRequested;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['Fees'] = '\MangoPay\Money';

        return $subObjects;
    }
}
