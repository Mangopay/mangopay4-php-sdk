<?php

namespace MangoPay;

/**
 * Filter for the list of Settlements
 */
class FilterSettlements extends FilterBase
{
    /**
     * The status of the Settlement. Allowed values: PENDING_UPLOAD, UPLOADED, CREATED,
     * UNMATCHED, PARTIALLY_MATCHED, PENDING_FUNDS_RECEPTION, INSUFFICIENT_FUNDS,
     * RECONCILED, FAILED, CANCELLED.
     * Multiple values can be combined in a comma-separated list.
     * @var string
     */
    public $Status;

    /**
     * The third-party PSP name to filter by.
     * @var string
     */
    public $ExternalProviderName;

    /**
     * The three-letter ISO 4217 code of the currency to filter by.
     * @var string
     */
    public $Currency;
}
