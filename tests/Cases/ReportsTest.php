<?php

namespace MangoPay\Tests\Cases;

use MangoPay\FilterReports;

/**
 * Tests basic methods for report requests
 */
class ReportsTest extends Base
{
    public function test_ReportRequestTransactions_Create()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;

        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $this->assertNotNull($createReportRequest);
        $this->assertNotNull($createReportRequest->Id);
        $this->assertSame($createReportRequest->ReportType, \MangoPay\ReportType::Transactions);
        $this->assertInstanceOf(FilterReports::class, $createReportRequest->Filters);
    }

    public function test_ReportRequestWallets_Create()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Wallets;

        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $this->assertNotNull($createReportRequest);
        $this->assertNotNull($createReportRequest->Id);
        $this->assertSame($createReportRequest->ReportType, \MangoPay\ReportType::Wallets);
    }

    public function test_ReportRequest_Get()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $getReportRequest = $this->_api->Reports->Get($createReportRequest->Id);

        $this->assertNotNull($getReportRequest);
        $this->assertSame($getReportRequest->Id, $createReportRequest->Id);
        $this->assertSame($getReportRequest->ReportType, $createReportRequest->ReportType);
    }

    public function test_ReportRequest_All()
    {
        $pagination = new \MangoPay\Pagination(1, 1);

        $getAllReportRequests = $this->_api->Reports->GetAll($pagination);

        $this->assertEquals(1, count($getAllReportRequests));
        $this->assertInstanceOf('\MangoPay\ReportRequest', $getAllReportRequests[0]);
    }

    public function test_ReportRequest_All_SortByCreationDate()
    {
        $pagination = new \MangoPay\Pagination(1, 1);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);

        $getAllReportRequests = $this->_api->Reports->GetAll($pagination, null, $sorting);

        $this->assertEquals(1, count($getAllReportRequests));
        $this->assertInstanceOf('\MangoPay\ReportRequest', $getAllReportRequests[0]);
    }

    public function test_Issue467()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Wallets;
        $reportRequest->CallbackURL = "/MangopayUsersExportUpdate.php";
        $reportRequest->DownloadFormat = "CSV";
        $reportRequest->Sort = "CreationDate:DESC";
        $reportRequest->Preview = false;
        $reportRequest->Filters = new \MangoPay\FilterReports();
        $reportRequest->Filters->MinBalanceAmount = 10;

        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $getReportRequest = $this->_api->Reports->Get($createReportRequest->Id);

        $this->assertNotNull($getReportRequest);
    }
}
