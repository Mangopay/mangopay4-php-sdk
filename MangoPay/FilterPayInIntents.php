<?php

namespace MangoPay;

/**
 * Filter for the list of PayInIntents
 */
class FilterPayInIntents extends FilterBase
{
    /**
     * The status of the Intent. Allowed values: AUTHORIZED, CAPTURED, PARTIALLY_CAPTURED,
     * REFUNDED, REFUND_REVERSED, DISPUTED, DISPUTED_WON, DISPUTED_LOST, DEFENDED, CANCELLED.
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
