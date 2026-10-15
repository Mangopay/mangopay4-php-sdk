<?php

namespace MangoPay;

/**
 * Filter for the list of PayInIntent splits
 */
class FilterPayInIntentSplits extends FilterBase
{
    /**
     * The status of the Split. Allowed values: CREATED, PENDING_FUNDS_RECEPTION, AVAILABLE,
     * PENDING, COMPLETED, REJECTED, FAILED, REVERSED, REFUND_SPLIT_PENDING,
     * REFUND_SPLIT_REJECTED, REFUND_SPLIT_COMPLETED.
     * Multiple values can be combined in a comma-separated list.
     * @var string
     */
    public $Status;

    /**
     * The third-party PSP name of the parent intent to filter by.
     * @var string
     */
    public $ExternalProviderName;

    /**
     * The three-letter ISO 4217 code of the currency to filter by.
     * @var string
     */
    public $Currency;
}
