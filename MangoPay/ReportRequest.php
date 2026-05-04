<?php

namespace MangoPay;

/**
 * Report request entity
 */
class ReportRequest extends Libraries\EntityBase
{
    /**
     * Date of when the report was requested.
     * @var int
     */
    public $ReportDate;

    /**
     * Status of the report.
     * @var string
     * @see \MangoPay\ReportStatus
     */
    public $Status;

    /**
     * Download file format.
     * @var string
     */
    public $DownloadFormat;

    /**
     * Download URL.
     * @var ?string
     */
    public $DownloadURL;

    /**
     * Callback URL.
     * @var string
     */
    public $CallbackURL;

    /**
     * Type of the report.
     * @var string
     * @see \MangoPay\ReportType
     */
    public $ReportType;

    /**
     * Sorting.
     * @var string
     */
    public $Sort;

    /**
     * If true, the report will be limited to the first 10 lines.
     * @var bool
     */
    public $Preview;

    /**
     * Filters for the report list.
     * @var \MangoPay\FilterReports
     */
    public $Filters;

    /**
     * Allowed values: "Alias", "BankAccountId", "BankWireRef", "CardId",
     * "CardType", "Country", "Culture", "Currency", "DeclaredDebitedFundsAmount",
     * "DeclaredDebitedFundsCurrency", "DeclaredFeesAmount",
     * "DeclaredFeesCurrency", "ExecutionType", "ExpirationDate", "PaymentType",
     * "PreauthorizationId", "WireReference".
     * @var array
     */
    public $Columns;

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

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Filters'] = '\MangoPay\FilterReports';

        return $subObjects;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'ReportDate');
        array_push($properties, 'DownloadURL');
        array_push($properties, 'Status');
        array_push($properties, 'ResultCode');
        array_push($properties, 'ResultMessage');

        return $properties;
    }
}
