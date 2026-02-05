<?php

namespace MangoPay;

class Conversion extends Libraries\EntityBase
{
    /**
     * The unique identifier of the active quote which guaranteed the rate for the conversion.
     * Null for Instant Conversions.
     * @var string
     */
    public $QuoteId;

    /**
     * The type of transaction
     * @var string
     * @see \MangoPay\TransactionType
     */
    public $Type;

    /**
     * The nature of the transaction, providing more
     * information about the context in which the transaction occurred:
     * @var string
     * @see \MangoPay\TransactionNature
     */
    public $Nature;

    /**
     * The status of the transaction.
     * @var string
     * @see \MangoPay\TransactionStatus
     */
    public $Status;

    /**
     * The unique identifier of the user at the source of the transaction.
     * @var string
     */
    public $AuthorId;

    /**
     * The unique identifier of the debited wallet.
     * @var string
     */
    public $DebitedWalletId;

    /**
     * The unique identifier of the credited wallet
     * @var string
     */
    public $CreditedWalletId;

    /**
     * The sell funds
     * @var Money
     */
    public $DebitedFunds;


    /**
     * The buy funds
     * @var Money
     */
    public $CreditedFunds;

    /**
     * Information about the fees taken by the platform for
     * this transaction (and hence transferred to the Fees Wallet).
     * Null for Instant Conversions between client wallets.
     * @var Money
     */
    public $Fees;

    /**
     * The requested fees
     * @var CustomFees|null
     */
    public $RequestedFees;

    /**
     * The code indicates the result of the operation.
     * This information is mostly used to handle errors or for filtering purposes.
     * @var string
     */
    public $ResultCode;

    /**
     * The explanation of the result code.
     * @var string
     */
    public $ResultMessage;

    /**
     * The date and time at which the status changed to SUCCEEDED,
     * indicating that the transaction occurred.
     * The statuses CREATED and FAILED return an ExecutionDate of null
     * @var int
     */
    public $ExecutionDate;

    /**
     * Real time indicative market rate of a specific currency pair
     * @var ConversionRate
     */
    public $ConversionRateResponse;

    /**
     * @var MarginsResponse|null
     */
    public $MarginsResponse;
}
