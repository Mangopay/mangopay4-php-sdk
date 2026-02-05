<?php

namespace MangoPay;

class PayInIntentSplit extends Libraries\EntityBase
{
    /**
     * @var string The unique identifier of an item in Mangopay ecosystem
     */
    public $LineItemId;

    /**
     * @var string The unique identifier of the seller providing the item (userId)
     */
    public $SellerId;

    /**
     * @var string The unique identifier of the wallet to credit the seller funds
     */
    public $WalletId;

    /**
     * @var int Information about the amount to be credited to the seller wallet
     */
    public $SplitAmount;

    /**
     * @var int Information about the fees
     */
    public $FeesAmount;

    /**
     * @var int Information about the date when the funds are to be transferred to the seller’s wallet
     * Must be a date in the future
     */
    public $TransferDate;

    /**
     * @var string The description of the split object
     */
    public $Description;

    /**
     * @var string The status of the split
     */
    public $Status;

    /**
     * The source wallet identifier
     * @var string|null
     */
    public $SplitOriginWalletId;
}
