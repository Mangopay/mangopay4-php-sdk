<?php

namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterTransactions extends FilterBase
{
    /**
     * @var string
     * @see TransactionStatus
     */
    public $Status;

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
     * @var string
     */
    public $ResultCode;

    /**
     * @var string
     * Possible values: USER_PRESENT, USER_NOT_PRESENT.
     *
     * In case USER_PRESENT is used and SCA is required, an error containing the RedirectUrl will be thrown
     */
    public $ScaContext;
}
