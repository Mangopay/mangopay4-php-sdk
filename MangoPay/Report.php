<?php

namespace MangoPay;

/**
 * Report entity
 */
class Report extends Libraries\EntityBase
{
    /**
     * The date and time at which the report was generated.
     * @var int
     */
    public $ReportDate;

    /**
     * Status of the report.
     * Returned values: PENDING, READY_FOR_DOWNLOAD, FAILED, EXPIRED
     * @var string
     */
    public $Status;

    /**
     * Result code.
     * @var string
     */
    public $ResultCode;

    /**
     * Result message.
     * @var string
     */
    public $ResultMessage;

    /**
     * The format in which the report is going to be downloaded.
     * @var string
     */
    public $DownloadFormat;

    /**
     * The URL at which the report file can be downloaded when the Status is GENERATED.
     * @var string
     */
    public $DownloadURL;

    /**
     * Type of the report: USER_WALLET_TRANSACTIONS, COLLECTED_FEES
     * @var string
     */
    public $ReportType;

    /**
     * Sorting.
     * @var string
     */
    public $Sort;

    /**
     * The date and time after which the report’s transaction was created, based on the transaction’s CreationDate.
     * @var int
     */
    public $AfterDate;

    /**
     * The date and time before which the report’s transaction was created, based on the transaction’s CreationDate.
     * @var int
     */
    public $BeforeDate;

    /**
     * The filers to apply if the ReportType is USER_WALLET_TRANSACTIONS (no filters available for COLLECTED_FEES).
     * The Currency and WalletId cannot be used together.
     * @var ReportFilters
     */
    public $Filters;

    /**
     * The data columns to be included in the report.
     *
     * Possible values: The columns listed in the Reports guide, which differ according to the report type.
     *
     * Default values: The default columns listed in the Reports guide, which differ according to the report type.
     * @var array
     */
    public $Columns;

    /**
     * @var string|null
     */
    public $DateFilterBy;
}
