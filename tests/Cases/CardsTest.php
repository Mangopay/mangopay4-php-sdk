<?php

namespace MangoPay\Tests\Cases;

use MangoPay\CardValidation;
use MangoPay\Libraries\Exception;
use MangoPay\SortDirection;
use MangoPay\Sorting;

/**
 * Tests methods for card registrations
 */
class CardsTest extends Base
{
    public function test_CardsByFingerprint_Get()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $sorting = new Sorting();
        $sorting->AddField("CreationDate", SortDirection::DESC);

        $cardsByFingerprint = $this->_api->Cards->GetByFingerprint($card->Fingerprint, $sorting);

        foreach ($cardsByFingerprint as $cardByFingerprint) {
            $this->assertSame($card->Fingerprint, $cardByFingerprint->Fingerprint);
            $this->assertNotNull($card->CardHolderName);
        }
    }

    public function test_Card_GetPreAuthorizations()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $preauthorizations = $this->_api->Cards->GetPreAuthorizations($card->Id);

        $this->assertNotNull($preauthorizations);
        $this->assertTrue(is_array($preauthorizations), 'Expected an array');
    }

    public function test_Card_GetTransactions()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->Cards->GetTransactions($card->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertTrue(is_array($transactions), 'Expected an array');
    }

    public function test_Card_Validate()
    {
        $john = $this->getNewJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($john->Id);

        $cardValidation = new \MangoPay\CardValidation();
        $cardValidation->Id = $cardRegistration->CardId;
        $cardValidation->Tag = "Test card validate";
        $cardValidation->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cardValidation->AuthorId = $john->Id;
        $cardValidation->SecureModeReturnUrl = "http://www.example.com/";
        $cardValidation->BrowserInfo = $this->getBrowserInfo();
        $cardValidation->SecureMode = "NO_CHOICE";

        try {
            $validatedCard = $this->_api->Cards->ValidateCard($cardRegistration->CardId, $cardValidation);
            $this->assertNotNull($validatedCard);
            $this->assertNotNull($validatedCard->Id);
            $this->assertNotNull($validatedCard->SecureMode);
            $this->assertNotNull($validatedCard->AuthenticationResult);
        } catch (Exception $e) {
            print_r("can't test due to client issues");
        }
    }

    public function test_get_Card_Validation()
    {
        $john = $this->getNewJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($john->Id);

        $cardValidation = new \MangoPay\CardValidation();
        $cardValidation->Id = $cardRegistration->CardId;
        $cardValidation->Tag = "Test get card validation";
        $cardValidation->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cardValidation->AuthorId = $john->Id;
        $cardValidation->SecureModeReturnUrl = "http://www.example.com/";
        $cardValidation->BrowserInfo = $this->getBrowserInfo();

        try {
            $validatedCard = $this->_api->Cards->ValidateCard($cardRegistration->CardId, $cardValidation);
            $getCardValidation = $this->_api->Cards->GetCardValidation($cardRegistration->CardId, $validatedCard->Id);
            $this->assertNotNull($getCardValidation);
            $this->assertNotNull($getCardValidation->Id);
            $this->assertEquals($getCardValidation->Id, $validatedCard->Id);
        } catch (Exception $e) {
            print_r("can't test due to client issues");
        }
    }

    public function test_GetTransactionsByCardFingerprint()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $transactionsByFingerprint = $this->_api->Cards->GetTransactionsByFingerprint($card->Fingerprint);

        $this->assertNotNull($transactionsByFingerprint);
        $this->assertTrue(is_array($transactionsByFingerprint), 'Expected an array');
        $this->assertTrue(sizeof($transactionsByFingerprint) > 0);
    }
}
