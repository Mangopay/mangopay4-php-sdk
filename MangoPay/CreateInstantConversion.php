<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class CreateInstantConversion extends Dto
{
    /**
     * The unique identifier of the user at the source of the transaction.
     * @var string
     */
    public $AuthorId;

    /**
     * The unique identifier of the debited wallet
     *
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
     * Information about the fees taken by the platform for this transaction (and hence transferred to the Fees Wallet).
     * @var CustomFees
     */
    public $Fees;

    /**
     * Custom data.
     * @var string
     */
    public $Tag;

    /**
     * @var UserMargin|null
     */
    public $UserMargin;
}
