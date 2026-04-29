<?php

namespace MangoPay;

use MangoPay\Libraries\EntityBase;

class ConversionQuote extends EntityBase
{
    /**
     * Expiration date
     * @var int
     */
    public $ExpirationDate;

    /**
     * @var string
     * @see \MangoPay\TransactionStatus
     */
    public $Status;

    /**
     * The time in seconds during which the quote is active and can be used for conversions.
     * @var int
     */
    public $Duration;

    /**
     * Debited funds
     * @var \MangoPay\Money
     */
    public $DebitedFunds;

    /**
     * Credited funds
     * @var \MangoPay\Money
     */
    public $CreditedFunds;

    /**
     * Information about the fees taken by the platform for this transaction (and hence transferred to the Fees Wallet).
     * Note: For conversions between client wallets, the quote cannot have Fees specified.
     * @var CustomFees|null
     */
    public $Fees;

    /**
     * The requested fees
     * @var CustomFees|null
     */
    public $RequestedFees;

    /**
     * @var ConversionRate
     */
    public $ConversionRateResponse;

    /**
     * @var UserMargin|null
     */
    public $UserMargin;

    /**
     * @var MarginsResponse|null
     */
    public $MarginsResponse;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['CreditedFunds'] = '\MangoPay\Money';
        $subObjects['Fees'] = '\MangoPay\CustomFees';
        $subObjects['RequestedFees'] = '\MangoPay\CustomFees';
        $subObjects['ConversionRateResponse'] = '\MangoPay\ConversionRate';
        $subObjects['UserMargin'] = '\MangoPay\UserMargin';
        $subObjects['MarginsResponse'] = '\MangoPay\MarginsResponse';

        return $subObjects;
    }
}
