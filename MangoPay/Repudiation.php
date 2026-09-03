<?php

namespace MangoPay;

/**
 * Repudiation entity
 */
class Repudiation extends Libraries\EntityBase
{
    /**
     * The Id of the origin payin author
     * @var string
     */
    public $AuthorId;

    /**
     * The funds repudiated from the wallet
     * @var Money
     */
    public $DebitedFunds;

    /**
    * The fees taken on the repudiation – will always be 0 at this stage
    * @var Money
    */
    public $Fees;

    /**
     * The amount of credited funds – since there are currently no fees,
     * this will be equal to the DebitedFunds
     * @var Money
     */
    public $CreditedFunds;

    /**
     * The wallet from where the repudiation was taken
     * @var string
     */
    public $DebitedWalletId;

    /**
     * The status of the transfer
     * @var string
     * @see TransactionStatus
     */
    public $Status;

    /**
     * The transaction result code
     * @var string
     */
    public $ResultCode;

    /**
     * The transaction result message
     * @var string
     */
    public $ResultMessage;

    /**
     * The execution date of the repudiation
     * @var int Unix timestamp
     */
    public $ExecutionDate;

    /**
     * The Id of the dispute to which this repudation corresponds.
     * Note that this value may be null (if it was created before the Dispute
     * objects started to be used – October 2015)
     * @var string
     */
    public $DisputeId;

    /**
     * The Id of the transaction that was repudiated
     * @var string
     */
    public $InitialTransactionId;

    /**
     * The initial transaction type
     * @var string
     * @see TransactionType
     */
    public $InitialTransactionType;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'DebitedFunds' => '\MangoPay\Money',
            'Fees' => '\MangoPay\Money',
            'CreditedFunds' => '\MangoPay\Money',
        ];
    }
}
