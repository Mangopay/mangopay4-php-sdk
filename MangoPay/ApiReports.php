<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for reports
 */
class ApiReports extends Libraries\ApiBase
{
    /**
     * Creates new report request
     * @param ReportRequest $reportRequest
     * @return ReportRequest Report request instance returned from API
     */
    public function Create($reportRequest, $idempotencyKey = null)
    {
        $type = $reportRequest->ReportType;

        if (is_null($type) || strlen($type) == 0) {
            throw new Libraries\Exception('Report type property is required when create a report request.');
        }

        switch ($type) {
            case ReportType::Transactions:
                return $this->CreateObject('reports_transactions_create', $reportRequest, '\MangoPay\ReportRequest', $type, null, $idempotencyKey);
            case ReportType::Wallets:
                return $this->CreateObject('reports_wallets_create', $reportRequest, '\MangoPay\ReportRequest', $type, null, $idempotencyKey);
            default:
                throw new Libraries\Exception('Unexpected Report type. Wrong ReportType value.');
        }
    }

    /**
     * Gets report request.
     * @param string $reportRequestId Report request identifier
     * @return ReportRequest Report request instance returned from API
     */
    public function Get($reportRequestId)
    {
        return $this->GetObject('reports_get', '\MangoPay\ReportRequest', $reportRequestId);
    }

    /**
     * Gets all report requests.
     * @param Pagination $pagination Pagination object
     * @param FilterTransactions $filter Object to filter data
     * @param Sorting $sorting Object to sorting data
     * @return ReportRequest Array with report requests
     */
    public function GetAll(& $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('reports_all', $pagination, 'MangoPay\ReportRequest', null, $filter, $sorting);
    }
}
