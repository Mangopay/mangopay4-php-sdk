<?php

namespace MangoPay;

/**
 * Report filters. To be used when creating a Report
 */
class ReportFilters extends Libraries\Dto
{
    /**
     * The currency of the DebitedFunds, CreditedFunds, or Fees of the transactions (and therefore the wallets).
     * @var string
     */
    public $Currency;

    /**
     * The unique identifier of the user referenced as the AuthorId or CreditedUserId of the transaction.
     * @var string
     */
    public $UserId;

    /**
     * The unique identifier of the wallet referenced as the DebitedWalletId or CreditedWalletId of the transaction.
     * @var string
     */
    public $WalletId;

    /**
     * @var string
     */
    public $PaymentMethod;

    /**
     * @var string
     */
    public $Status;

    /**
     * @var string
     */
    public $Type;

    /**
     * @var string
     */
    public $IntentId;

    /**
     * @var string
     */
    public $ExternalProviderName;

    /**
     * @var bool
     */
    public $Scheduled;

    /**
     * @var string
     */
    public $SettlementId;
}
