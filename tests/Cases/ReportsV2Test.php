<?php

namespace Cases;

use MangoPay\FilterReportsV2;
use MangoPay\Report;
use MangoPay\ReportFilters;
use MangoPay\Tests\Cases\Base;

/**
 * Tests basic methods for report requests
 */
class ReportsV2Test extends Base
{
    public function test_Reports_Create_CollectedFees()
    {
        $report = $this->getNewReportInstance();
        $created = $this->_api->ReportsV2->Create($report);

        $this->assertNotNull($created);
        $this->assertNotNull($created->Id);
        $this->assertSame($created->ReportType, "COLLECTED_FEES");
        $this->assertSame($created->Status, "PENDING");
    }

    public function test_Reports_Create_UserWalletTransactions()
    {
        $report = new Report();
        $report->ReportType = "USER_WALLET_TRANSACTIONS";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $created = $this->_api->ReportsV2->Create($report);

        $this->assertNotNull($created);
        $this->assertNotNull($created->Id);
        $this->assertSame($created->ReportType, "USER_WALLET_TRANSACTIONS");
        $this->assertSame($created->Status, "PENDING");
    }

    public function test_Reports_Create_DateFilterBy()
    {
        $report = new Report();
        $report->ReportType = "COLLECTED_FEES";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $report->DateFilterBy = "CreationDate";
        $created = $this->_api->ReportsV2->Create($report);

        $this->assertNotNull($created);
        $this->assertSame($created->ReportType, "COLLECTED_FEES");
        $this->assertSame($created->Status, "PENDING");
    }

    public function test_Reports_Get()
    {
        $report = $this->getNewReportInstance();
        $created = $this->_api->ReportsV2->Create($report);
        $fetched = $this->_api->ReportsV2->Get($created->Id);

        $this->assertNotNull($fetched);
        $this->assertNotNull($fetched->Id);
        $this->assertSame($created->Id, $fetched->Id);
    }

    public function test_Reports_GetAll()
    {
        $report = $this->getNewReportInstance();
        $this->_api->ReportsV2->Create($report);
        $fetched = $this->_api->ReportsV2->GetAll();

        $this->assertNotNull($fetched);
        $this->assertTrue(sizeof($fetched) > 0);
    }

    public function test_Reports_GetAll_Filtered()
    {
        $report = $this->getNewReportInstance();
        $this->_api->ReportsV2->Create($report);
        $allResults = $this->_api->ReportsV2->GetAll();

        $filter = new FilterReportsV2();
        $filter->Status = "PENDING";
        $filteredResults = $this->_api->ReportsV2->GetAll($filter);

        $this->assertNotNull($filteredResults);
        $this->assertTrue(sizeof($allResults) > sizeof($filteredResults));
    }

    public function getNewReportInstance()
    {
        $report = new Report();
        $report->ReportType = "COLLECTED_FEES";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        return $report;
    }

    public function test_Create_Intent_Report()
    {
        $report = new Report();
        $report->ReportType = "ECHO_INTENT";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $filters = new ReportFilters();
        $filters->Status = "CAPTURED";
        $filters->PaymentMethod = "PAYPAL";
        $filters->Type = "PAYIN";
        $report->Filters = $filters;
        $result = $this->_api->ReportsV2->Create($report);
        $this->assertSame($result->ReportType, "ECHO_INTENT");
        $this->assertSame($result->Status, "PENDING");
        $this->assertSame($result->Filters->Status, "CAPTURED");
    }

    public function test_Create_Intent_Action_Report()
    {
        $report = new Report();
        $report->ReportType = "ECHO_INTENT_ACTION";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $filters = new ReportFilters();
        $filters->Status = "CAPTURED";
        $filters->PaymentMethod = "PAYPAL";
        $filters->Type = "PAYIN";
        $report->Filters = $filters;
        $result = $this->_api->ReportsV2->Create($report);
        $this->assertSame($result->ReportType, "ECHO_INTENT_ACTION");
        $this->assertSame($result->Status, "PENDING");
        $this->assertSame($result->Filters->Status, "CAPTURED");
    }

    public function test_Create_Settlement_Report()
    {
        $report = new Report();
        $report->ReportType = "ECHO_SETTLEMENT";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $filters = new ReportFilters();
        $filters->Status = "RECONCILED";
        $filters->ExternalProviderName = "PAYPAL";
        $report->Filters = $filters;
        $result = $this->_api->ReportsV2->Create($report);
        $this->assertSame($result->ReportType, "ECHO_SETTLEMENT");
        $this->assertSame($result->Status, "PENDING");
        $this->assertSame($result->Filters->Status, "RECONCILED");
    }

    public function test_Create_Split_Report()
    {
        $report = new Report();
        $report->ReportType = "ECHO_SPLIT";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $filters = new ReportFilters();
        $filters->Status = "COMPLETED";
        $filters->IntentId = "int_0197f975-63f6-714e-8fc6-4451e128170f";
        $filters->Scheduled = false;
        $report->Filters = $filters;
        $result = $this->_api->ReportsV2->Create($report);
        $this->assertSame($result->ReportType, "ECHO_SPLIT");
        $this->assertSame($result->Status, "PENDING");
        $this->assertSame($result->Filters->Status, "COMPLETED");
        $this->assertSame($result->Filters->IntentId, "int_0197f975-63f6-714e-8fc6-4451e128170f");
    }
}
