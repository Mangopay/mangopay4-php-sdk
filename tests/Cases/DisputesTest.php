<?php

namespace MangoPay\Tests\Cases;

use MangoPay\DisputeDocumentStatus;
use MangoPay\FilterDisputeDocuments;
use MangoPay\SortDirection;
use MangoPay\Sorting;

/**
 * Tests basic methods for disputes
 */
class DisputesTest extends Base
{
    /**
     * IMPORTANT NOTE!
     *
     * Due to the fact the disputes CANNOT be created on user's side,
     * a special approach in testing is needed.
     * In order to get the tests below pass, a bunch of disputes have
     * to be prepared on the API's side - if they're not, you can
     * just skip these tests, as they won't pass.
     *
     */

    private $_clientDisputes = null;

    public function test_Disputes_Get()
    {
        $this->init();

        $this->assertEquals("0", "0");
        $dispute = $this->_api->Disputes->Get($this->_clientDisputes[0]->Id);

        $this->assertNotNull($dispute);
        $this->assertEquals($dispute->Id, $this->_clientDisputes[0]->Id);
    }

    public function test_Disputes_GetTransactions()
    {
        $this->init();

        $disputeToTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->DisputeType == \MangoPay\DisputeType::NotContestable) {
                $disputeToTest = $dispute;
                break;
            }
        }
        if (is_null($disputeToTest)) {
            $this->markTestSkipped("Cannot test getting transactions for dispute because there's no not costestable disputes in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();

        $result = $this->_api->Disputes->GetTransactions($disputeToTest->Id, $pagination);

        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }

    public function test_Disputes_GetDisputesForWallet()
    {
        $this->init();

        $disputeWallet = null;
        foreach ($this->_clientDisputes as $dispute) {
            if (!is_null($dispute->InitialTransactionId)) {
                $disputeWallet = $dispute;
                break;
            }
        }
        if (is_null($disputeWallet)) {
            $this->markTestSkipped("Cannot test getting disputes for wallet because there's no disputes with transaction ID in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $wallet = $this->_api->PayIns->Get($disputeWallet->InitialTransactionId);

        $result = $this->_api->Disputes->GetDisputesForWallet($wallet->CreditedWalletId, $pagination);

        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }

    public function test_Disputes_GetDisputesForUser()
    {
        $this->init();

        $disputeToTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->DisputeType == \MangoPay\DisputeType::NotContestable) {
                $disputeToTest = $dispute;
                break;
            }
        }
        if (is_null($disputeToTest)) {
            $this->markTestSkipped("Cannot test getting disputes for user because there's no not costestable disputes in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($dispute->Id, $pagination);
        $userId = $transactions[0]->AuthorId;
        $result = $this->_api->Disputes->GetDisputesForUser($userId, $pagination);

        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }

    public function test_Disputes_GetDisputesForPayIn()
    {
        $this->init();

        $disputeWallet = null;
        foreach ($this->_clientDisputes as $dispute) {
            if (!is_null($dispute->InitialTransactionId)) {
                $disputeWallet = $dispute;
                break;
            }
        }
        if (is_null($disputeWallet)) {
            $this->markTestSkipped("Cannot test getting disputes for wallet because there's no disputes with transaction ID in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $payIn = $this->_api->PayIns->Get($disputeWallet->InitialTransactionId);

        $result = $this->_api->Disputes->GetDisputesForPayIn($payIn->Id, $pagination);

        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }

    public function test_Disputes_CreateDisputeDocument()
    {
        $this->init();

        $result = $this->getNewDisputeDocument();
        $this->assertNotNull($result);
        $this->assertEquals(\MangoPay\DisputeDocumentType::DeliveryProof, $result->Type);
        $this->assertNotNull($result->DisputeId);
    }

    public function test_Disputes_CreateDisputePage()
    {
        $this->init();

        $disputeForDoc = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction) {
                $disputeForDoc = $dispute;
                break;
            }
        }
        if (is_null($disputeForDoc)) {
            $this->markTestSkipped("Cannot test creating dispute document page because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $documentCreated = $this->_api->Disputes->CreateDisputeDocument($disputeForDoc->Id, $document);

        $this->_api->Disputes->CreateDisputeDocumentPageFromFile($disputeForDoc->Id, $documentCreated->Id, __DIR__ . "/../TestKycPageFile.png");
        $this->assertTrue(true);
    }

    public function test_Disputes_CreateDisputeDocumentConsult()
    {
        $this->init();

        $disputeForDoc = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction) {
                $disputeForDoc = $dispute;
                break;
            }
        }
        if (is_null($disputeForDoc)) {
            $this->markTestSkipped("Cannot test creating dispute document consult because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $documentCreated = $this->_api->Disputes->CreateDisputeDocument($disputeForDoc->Id, $document);

        $this->_api->Disputes->CreateDisputeDocumentPageFromFile($disputeForDoc->Id, $documentCreated->Id, __DIR__ . "/../TestKycPageFile.png");

        $documentConsults = $this->_api->DisputeDocuments->CreateDisputeDocumentConsult($documentCreated->Id);

        $this->assertNotNull($documentConsults);
        $this->assertTrue(is_array($documentConsults), 'Expected an array');
    }

    public function test_Disputes_ResubmitDispute()
    {
        $this->init();

        $toTestDispute = null;
        foreach ($this->_clientDisputes as $dispute) {
            if (($dispute->DisputeType == \MangoPay\DisputeType::Contestable
                    || $dispute->DisputeType == \MangoPay\DisputeType::Retrieval)
                && ($dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction)
                && ($dispute->ContestDeadlineDate > time())) {
                $toTestDispute = $dispute;
                break;
            }
        }
        if (is_null($toTestDispute)) {
            $this->markTestSkipped("Cannot test contesting dispute because there's no disputes that can be resubmited in the disputes list.");
            return;
        }

        $result = $this->_api->Disputes->ResubmitDispute($toTestDispute->Id);

        $this->assertNotNull($result);
        $this->assertEquals($toTestDispute->Id, $result->Id);
        $this->assertEquals(\MangoPay\DisputeStatus::Submitted, $result->Status);
    }

    public function test_Disputes_Update()
    {
        $this->init();

        $newTag = "New tag " . time();
        $dispute = new \MangoPay\Dispute();
        $dispute->Id = $this->_clientDisputes[0]->Id;
        $dispute->Tag = $newTag;

        $result = $this->_api->Disputes->Update($dispute);

        $this->assertNotNull($result);
        $this->assertEquals($newTag, $result->Tag);
    }

    public function test_Disputes_CloseDispute()
    {
        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if (($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction)
                && ($dispute->ContestDeadlineDate > time())
            ) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test closing dispute because there's no available disputes with expected status in the disputes list.");
            return;
        }

        $result = $this->_api->Disputes->CloseDispute($disputeForTest->Id);

        $this->assertNotNull($result);
        $this->assertEquals(\MangoPay\DisputeStatus::Closed, $result->Status);
    }

    public function test_Disputes_GetDocument()
    {
        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test getting dispute's document because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::Other;
        $docCreated = $this->_api->Disputes->CreateDisputeDocument($disputeForTest->Id, $document);

        $result = $this->_api->DisputeDocuments->Get($docCreated->Id);

        $this->assertNotNull($result);
        $this->assertEquals($docCreated->CreationDate, $result->CreationDate);
        $this->assertEquals($docCreated->Id, $result->Id);
        $this->assertEquals($docCreated->RefusedReasonMessage, $result->RefusedReasonMessage);
        $this->assertEquals($docCreated->RefusedReasonType, $result->RefusedReasonType);
        $this->assertEquals($docCreated->Status, $result->Status);
        $this->assertEquals($docCreated->Tag, $result->Tag);
        $this->assertEquals($docCreated->Type, $result->Type);
        $this->assertEquals($disputeForTest->Id, $result->DisputeId);
    }

    public function test_Disputes_GetDocumentsForDispute()
    {
        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::Submitted) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $disputeForTest = $this->test_Disputes_ContestDispute();
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test getting dispute's documents because there's no available disputes with SUBMITTED status in the disputes list.");
            return;
        }

        $result = $this->_api->Disputes->GetDocumentsForDispute($disputeForTest->Id);

        $this->assertNotNull($result);
    }

    public function test_Disputes_ContestDispute()
    {
        $this->init();

        $notContestedDispute = null;
        foreach ($this->_clientDisputes as $dispute) {
            if (($dispute->DisputeType == \MangoPay\DisputeType::Contestable
                    || $dispute->DisputeType == \MangoPay\DisputeType::Retrieval)
                && ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction)
                && ($dispute->ContestDeadlineDate > time())
            ) {
                $notContestedDispute = $dispute;
                break;
            }
        }
        if (is_null($notContestedDispute)) {
            $this->markTestSkipped("Cannot test contesting dispute because there's no disputes that can be contested in the disputes list.");
            return;
        }
        $contestedFunds = null;
        if ($notContestedDispute->Status == \MangoPay\DisputeStatus::PendingClientAction) {
            $contestedFunds = new \MangoPay\Money();
            $contestedFunds->Amount = 10;
            $contestedFunds->Currency = "EUR";
        }

        $result = $this->_api->Disputes->ContestDispute($notContestedDispute->Id, $contestedFunds);

        $this->assertNotNull($result);
        $this->assertEquals($notContestedDispute->Id, $result->Id);
        $this->assertEquals(\MangoPay\DisputeStatus::Submitted, $result->Status);

        return $result; // used in test_Disputes_GetDocumentsForDispute()
    }

    public function test_Disputes_GetAllDocuments()
    {
        $this->init();

        $pagination = new \MangoPay\Pagination();
        $sorting = new Sorting();
        $sorting->AddField("CreationDate", SortDirection::DESC);
        $filter = new FilterDisputeDocuments();
        $filter->Status = DisputeDocumentStatus::Created;
        $result = $this->_api->DisputeDocuments->GetAll($pagination, $sorting, $filter);

        $this->assertNotNull($result);
    }

    public function test_Disputes_UpdateDisputeDocument()
    {
        $this->markTestSkipped('Disputes need to be fixed, the data on the account needs to be fixed, ref: https://github.com/Mangopay/mangopay2-php-sdk/issues/85');

        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test submitting dispute's documents because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $disputeDocument = $this->_api->Disputes->CreateDisputeDocument($disputeForTest->Id, $document);

        $this->_api->Disputes->CreateDisputeDocumentPageFromFile($disputeForTest->Id, $disputeDocument->Id, __DIR__ . "/../TestKycPageFile.png");

        $disputeDocument->Status = \MangoPay\DisputeDocumentStatus::ValidationAsked;

        $result = $this->_api->Disputes->UpdateDisputeDocument($disputeForTest->Id, $disputeDocument);

        $this->assertNotNull($result);
        $this->assertEquals($disputeDocument->Type, $result->Type);
        $this->assertTrue($result->Status == \MangoPay\DisputeDocumentStatus::ValidationAsked);
    }

    public function test_Disputes_GetRepudiation()
    {
        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if (!is_null($dispute->InitialTransactionId && $dispute->DisputeType == \MangoPay\DisputeType::NotContestable)) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test getting repudiation because there's no not costestable disputes with transaction ID in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($disputeForTest->Id, $pagination);

        if (empty($transactions)) {
            $this->markTestSkipped("Cannot test getting repudiation because dispute has no transaction.");
            return;
        }

        $repudiationId = $transactions[0]->Id;

        $result = $this->_api->Disputes->GetRepudiation($repudiationId);

        $this->assertNotNull($result);
        $this->assertEquals($repudiationId, $result->Id);
    }

    public function test_Disputes_CreateSettlementTransfer()
    {
        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::Closed && $dispute->DisputeType == \MangoPay\DisputeType::NotContestable) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test creating settlement transfer because there's no closed, not costestable disputes in the disputes list.");
            return;
        }
        $this->markTestSkipped("404 not found");

        $transfer = $this->getNewSettlementTransfer();
        $this->assertNotNull($transfer);
        $this->assertTrue($transfer->Type == 'TRANSFER');
        $this->assertTrue($transfer->Nature == 'SETTLEMENT');

        $fetchedTransfer = $this->_api->Disputes->GetSettlementTransfer($transfer->Id);
        $this->assertTrue($transfer->Id == $fetchedTransfer->Id);
        $this->assertTrue($transfer->CreationDate == $fetchedTransfer->CreationDate);
    }

    public function test_Repudiations_GetRefunds()
    {
        $this->init();

        $disputeForTest = null;
        foreach ($this->_clientDisputes as $dispute) {
            if ($dispute->Status == \MangoPay\DisputeStatus::Closed && $dispute->DisputeType == \MangoPay\DisputeType::NotContestable) {
                $disputeForTest = $dispute;
                break;
            }
        }
        if (is_null($disputeForTest)) {
            $this->markTestSkipped("Cannot test getting repudiation's refunds because there's no closed, not costestable disputes in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($disputeForTest->Id, $pagination);
        $repudiationId = $transactions[0]->Id;
        $this->markTestSkipped("404 not found");
        $repudiation = $this->_api->Disputes->GetRepudiation($repudiationId);
        $filter = new \MangoPay\FilterRefunds();

        $refunds = $this->_api->Repudiations->GetRefunds($repudiation->Id, $pagination, $filter);

        $this->assertNotNull($refunds);
        $this->assertTrue(is_array($refunds), 'Expected an array');
    }

    /**
     * This function is like setUp but needs to be called on each tests
     */
    public function init()
    {
        $pagination = new \MangoPay\Pagination(1, 100);
        $sorting = new Sorting();
        $sorting->AddField("CreationDate", SortDirection::DESC);
        $this->_clientDisputes = $this->_api->Disputes->GetAll($pagination, $sorting);

        if (empty($this->_clientDisputes)) {
            $this->markTestSkipped('INITIALIZATION FAILURE - cannot test disputes. Not exist any dispute.');
        }
    }
}
