<?php

namespace MangoPay;

/**
 * Transaction entity.
 * Base class for: PayIn, PayOut, Transfer.
 */
class Transaction extends Libraries\EntityBase
{
    /**
     * Author Id
     * @var string
     */
    public $AuthorId;

    /**
     * Credited user Id
     * @var string
     */
    public $CreditedUserId;

    /**
     * Debited funds
     * @var Money
     */
    public $DebitedFunds;

    /**
     * Credited funds
     * @var Money
     */
    public $CreditedFunds;

    /**
     * Fees
     * @var Money
     */
    public $Fees;

    /**
     * @var string
     * @see TransactionStatus
     */
    public $Status;

    /**
     * Result code
     * @var string
     */
    public $ResultCode;

    /**
     * The PreAuthorization result Message explaining the result code
     * @var string
     */
    public $ResultMessage;

    /**
     * Execution date
     * @var int
     */
    public $ExecutionDate;

    /**
     * @var string
     * @see TransactionType
     */
    public $Type;

    /**
     * @var string
     * @see TransactionNature
     */
    public $Nature;

    /**
     * Debited wallet Id
     * @var string
     */
    public $DebitedWalletId;

    /**
     * Credited wallet Id
     * @var string
     */
    public $CreditedWalletId;

    /**
     * Deposit Id
     * @var string
     * @deprecated in favor of $ExtendedPreauthorizationId
     */
    public $DepositId;

    /**
     * Extended Preauthorization Id
     * @var string
     */
    public $ExtendedPreauthorizationId;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'DebitedFunds' => '\MangoPay\Money' ,
            'CreditedFunds' => '\MangoPay\Money' ,
            'Fees' => '\MangoPay\Money'
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
        array_push($properties, 'ExecutionDate');

        return $properties;
    }
}
