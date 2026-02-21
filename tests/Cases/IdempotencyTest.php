<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\ResponseException;
use MangoPay\Money;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsDirect;
use MangoPay\PayInPaymentDetailsBankWire;
use MangoPay\Report;

/**
 * Tests methods for idempotency support
 * See https://docs.mangopay.com/guide/idempotency-support/
 */
class IdempotencyTest extends Base
{
    // if post request called twice with no idempotency key, act independently
    public function test_NoIdempotencyKey_ActIndependently()
    {
        $user = $this->buildJohn();
        $user1 = $this->_api->Users->Create($user);
        $user2 = $this->_api->Users->Create($user);
        $this->assertTrue($user2->Id > $user1->Id);
    }

    // if post request called twice with same idempotency key, 2nd call is blocked

    /**
     * @throws \MangoPay\Libraries\Exception
     */
    public function test_SameIdempotencyKey_Blocks2ndCall()
    {
        $idempotencyKey = md5(uniqid());
        $user = $this->buildJohn();
        $this->expectException(ResponseException::class);
        $user1 = $this->_api->Users->Create($user);
        $user1 = $this->_api->Users->Create($user, $idempotencyKey);
        $user2 = $this->_api->Users->Create($user, $idempotencyKey);
        $this->assertNull($user2);
    }

    // if post request called twice with different idempotency key, act independently and responses may be retreived later
    public function test_DifferentIdempotencyKey_ActIndependentlyAndRetreivable()
    {
        $idempotencyKey1 = md5(uniqid());
        $idempotencyKey2 = md5(uniqid());
        $user = $this->buildJohn();
        $user1 = $this->_api->Users->Create($user, $idempotencyKey1);
        $user2 = $this->_api->Users->Create($user, $idempotencyKey2);
        $this->assertTrue($user2->Id > $user1->Id);

        // responses may be retreived later
        $resp1 = $this->_api->Responses->Get($idempotencyKey1);
        $resp2 = $this->_api->Responses->Get($idempotencyKey2);
        $this->assertTrue($resp1->Resource->Id == $user1->Id);
        $this->assertTrue($resp2->Resource->Id == $user2->Id);
    }

    public function test_SameIdempotencyKey_ErrorAndGetBackError()
    {
        $idempotencyKey = md5(uniqid());
        $user = $this->buildJohn();
        $user->FirstName = null;// Trigger an error: The FirstName field is required
        try {
            $user1 = $this->_api->Users->Create($user, $idempotencyKey);
        } catch (ResponseException $exception) {
            // Check it is what we expect
            self::assertStringContainsString('The FirstName field is required', $exception->GetErrorDetails()->Errors->FirstName);
        }
        // Use case: the user lost the above exception and wants to get it back
        $response = $this->_api->Responses->Get($idempotencyKey);
        self::assertInstanceOf('MangoPay\Response', $response);
        self::assertInstanceOf('MangoPay\Libraries\Error', $response->Resource);
        self::assertStringContainsString('The FirstName field is required', $response->Resource->Errors->FirstName);
    }

    public function test_GetIdempotencyKey_PreauthorizationCreate()
    {
        $key = md5(uniqid());
        $this->getJohnsCardPreAuthorization($key);

        $this->assertIdempotencyResource($key, '\MangoPay\CardPreAuthorization');
    }

    public function test_GetIdempotencyKey_CardregistrationCreate()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR WITH MONEY';
        $wallet1 = $this->_api->Wallets->Create($wallet);
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $wallet1->Owners[0];
        $cardRegistration->Currency = 'EUR';
        $this->_api->CardRegistrations->Create($cardRegistration, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\CardRegistration');
    }

    public function test_GetIdempotencyKey_MandatesCreate()
    {
        $key = md5(uniqid());
        $account = $this->getJohnsAccount();
        $mandate = new \MangoPay\Mandate();
        $mandate->Tag = "Tag test";
        $mandate->BankAccountId = $account->Id;
        $mandate->ReturnURL = "http://www.mysite.com/returnURL/";
        $mandate->Culture = "FR";
        $this->_api->Mandates->Create($mandate, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\Mandate');
    }

    public function test_GetIdempotencyKey_PayinsCardWebCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $user->Id;
        $payIn->CreditedUserId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Currency = 'EUR';
        $payIn->Fees->Amount = 5;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardType = 'CB_VISA_MASTERCARD';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = 'https://test.com';
        $payIn->ExecutionDetails->TemplateURL = 'https://TemplateURL.com';
        $payIn->ExecutionDetails->SecureMode = 'DEFAULT';
        $payIn->ExecutionDetails->Culture = 'fr';
        $this->_api->PayIns->Create($payIn, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_PayinsCardDirectCreate()
    {
        $key = md5(uniqid());
        $johnWallet = $this->getJohnsWalletWithMoney();
        $beforeWallet = $this->_api->Wallets->Get($johnWallet->Id);
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        $userId = $user->Id;
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);
        $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);
        $card = $this->_api->Cards->Get($cardRegistration->CardId);
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardId = $card->Id;
        $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();

        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';

        $this->_api->PayIns->Create($payIn, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_PayinsPreauthorizedDirectCreate()
    {
        $key = md5(uniqid());
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 100;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
        $payIn->PaymentDetails->PreauthorizationId = $cardPreAuthorization->Id;
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        $this->_api->PayIns->Create($payIn, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_PayinsBankWireDirectCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 10000;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->PaymentDetails->DeclaredFees = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredFees->Amount = 0;
        $payIn->PaymentDetails->DeclaredFees->Currency = 'EUR';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $this->_api->PayIns->Create($payIn, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_PayinsDirectdebitWebCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 100;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
        $payIn->PaymentDetails->DirectDebitType = "GIROPAY";
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.mysite.com/returnURL/";
        $payIn->ExecutionDetails->Culture = "FR";
        $payIn->ExecutionDetails->TemplateURLOptions = new \MangoPay\PayInTemplateURLOptions();
        $payIn->ExecutionDetails->TemplateURLOptions->PAYLINE = "https://www.maysite.com/payline_template/";
        $this->_api->PayIns->Create($payIn, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_PayinsDirectdebitDirectCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        $userId = $user->Id;
        $mandate = $this->getJohnsMandate();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
        $payIn->PaymentDetails->MandateId = $mandate->Id;
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $this->_api->PayIns->Create($payIn, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsPaypalWebCreate()
    {
        $key = md5(uniqid());
        $this->getJohnsPayInPaypalWebV2($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsPayconiqWebCreate()
    {
        $key = md5(uniqid());
        $this->getJohnsPayInPayconiqWebV2($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsMbwayWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInMbwayWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsMultibancoWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInMultibancoWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsSatispayWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInSatispayWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsBlikWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInBlikWeb(null, false, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsKlarnaWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInKlarnaWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsIdealWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInIdealWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsGiropayWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInGiropayWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsBancontactWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInBancontactWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsBizumWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInBizumWeb(null, true, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsSwishWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInSwishWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsTwintWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInTwintWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_PayinsPayByBankWebCreate()
    {
        $key = md5(uniqid());
        $this->getNewPayInPayByBankWeb(null, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_CreateDepositPreauthorizedPayInWithoutComplement()
    {
        $key = md5(uniqid());
        $this->createDepositPreauthorizedPayInWithoutComplement($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_CreateDepositPreauthorizedPayInPriorToComplement()
    {
        $key = md5(uniqid());
        $this->createDepositPreauthorizedPayInPriorToComplement($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetItempotencyKey_CreateDepositPreauthorizedPayInComplement()
    {
        $this->markTestSkipped("skipped because of PSP technical error");
        $key = md5(uniqid());
        $this->createDepositPreauthorizedPayInComplement($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_PayinsCreateRefunds()
    {
        $key = md5(uniqid());
        $payIn = $this->getNewPayInCardDirect();
        $user = $this->getJohn();
        $refund = new \MangoPay\Refund();
        $refund->CreditedWalletId = $payIn->CreditedWalletId;
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = $payIn->DebitedFunds->Amount;
        $refund->DebitedFunds->Currency = $payIn->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = $payIn->Fees->Amount;
        $refund->Fees->Currency = $payIn->Fees->Currency;
        $this->_api->PayIns->CreateRefund($payIn->Id, $refund, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\Refund');
    }

    public function test_GetIdempotencyKey_PayoutsBankwireCreate()
    {
        $key = md5(uniqid());
        $payIn = $this->getNewPayInCardDirect();
        $account = $this->getJohnsAccount();
        $payOut = new \MangoPay\PayOut();
        $payOut->Tag = 'DefaultTag';
        $payOut->AuthorId = $payIn->AuthorId;
        $payOut->CreditedUserId = $payIn->AuthorId;
        $payOut->DebitedFunds = new \MangoPay\Money();
        $payOut->DebitedFunds->Currency = 'EUR';
        $payOut->DebitedFunds->Amount = 10;
        $payOut->Fees = new \MangoPay\Money();
        $payOut->Fees->Currency = 'EUR';
        $payOut->Fees->Amount = 5;
        $payOut->DebitedWalletId = $payIn->CreditedWalletId;
        $payOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
        $payOut->MeanOfPaymentDetails->BankAccountId = $account->Id;
        $payOut->MeanOfPaymentDetails->BankWireRef = 'Johns payment';
        $payOut->MeanOfPaymentDetails->PayoutModeRequested = 'STANDARD';
        $this->_api->PayOuts->Create($payOut, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\PayOut');
    }

    public function test_GetIdempotencyKey_PayOut_CheckEligibility()
    {
        $key = md5(uniqid());
        $payOut = $this->getJohnsPayOutForCardDirect();
        $this->createPayOutCheckEligibility($payOut, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayOutEligibilityResponse');
    }

    public function test_GetIdempotencyKey_CardDirect_getPaymentMethodMetadata()
    {
        $key = md5(uniqid());
        $payin = $this->getNewPayInCardDirect();

        $payment_method_metadata = new \MangoPay\PaymentMethodMetadata();
        $payment_method_metadata->Type = "BIN";
        $payment_method_metadata->Bin = ($payin->PaymentDetails->CardInfo->BIN);

        $this->_api->PayIns->GetPaymentMethodMetadata($payment_method_metadata, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PaymentMethodMetadata');
    }

    public function test_GetIdempotencyKey_CreateRecurringPayInRegistration()
    {
        $key = md5(uniqid());
        $this->getRecurringPayin(true, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayInRecurringRegistrationRequestResponse');
    }

    public function test_GetIdempotencyKey_CreateRecurringPayInCIT()
    {
        $key = md5(uniqid());
        $this->createRecurringPayInCIT($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayInRecurring');
    }

    public function test_GetIdempotencyKey_CreateRecurringPayPalPayInCIT()
    {
        $key = md5(uniqid());
        $this->createRecurringPaypalPayInCIT($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayInRecurring');
    }

    public function test_GetIdempotencyKey_Reports_Create_CollectedFees()
    {
        $key = md5(uniqid());
        $report = new Report();
        $report->ReportType = "COLLECTED_FEES";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $this->_api->ReportsV2->Create($report, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\Report');
    }

    public function test_GetIdempotencyKey_ReportsCreate()
    {
        $key = md5(uniqid());
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
        $this->_api->Reports->Create($reportRequest, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\ReportRequest');
    }

    public function test_GetIdempotencyKey_TransfersCreateRefunds()
    {
        $key = md5(uniqid());
        $transfer = $this->getNewTransfer();
        $user = $this->getJohn();
        $refund = new \MangoPay\Refund();
        $refund->DebitedWalletId = $transfer->DebitedWalletId;
        $refund->CreditedWalletId = $transfer->CreditedWalletId;
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = $transfer->DebitedFunds->Amount;
        $refund->DebitedFunds->Currency = $transfer->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = $transfer->Fees->Amount;
        $refund->Fees->Currency = $transfer->Fees->Currency;
        $this->_api->Transfers->CreateRefund($transfer->Id, $refund, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\Refund');
    }

    public function test_GetIdempotencyKey_TransfersCreate()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $walletWithMoney = $this->getJohnsWalletWithMoney();
        $wallet1 = new \MangoPay\Wallet();
        $wallet1->Owners = [$user->Id];
        $wallet1->Currency = 'EUR';
        $wallet1->Description = 'WALLET IN EUR FOR TRANSFER';
        $wallet = $this->_api->Wallets->Create($wallet1);
        $transfer = new \MangoPay\Transfer();
        $transfer->Tag = 'DefaultTag';
        $transfer->AuthorId = $user->Id;
        $transfer->CreditedUserId = $user->Id;
        $transfer->DebitedFunds = new \MangoPay\Money();
        $transfer->DebitedFunds->Currency = 'EUR';
        $transfer->DebitedFunds->Amount = 100;
        $transfer->Fees = new \MangoPay\Money();
        $transfer->Fees->Currency = 'EUR';
        $transfer->Fees->Amount = 0;
        $transfer->DebitedWalletId = $walletWithMoney->Id;
        $transfer->CreditedWalletId = $wallet->Id;
        $this->_api->Transfers->Create($transfer, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\Transfer');
    }

    public function test_GetIdempotencyKey_UsersCreateNatural()
    {
        $key = md5(uniqid());
        $user = $this->buildJohn();
        $this->_api->Users->Create($user, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\UserNatural');
    }

    public function test_GetIdempotencyKey_UsersCreateNaturalSca()
    {
        $key = md5(uniqid());
        $this->getJohnSca("OWNER", true, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\UserNaturalSca');
    }

    public function test_GetIdempotencyKey_UsersCreateLegal()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $user = new \MangoPay\UserLegal();
        $user->Name = "MartixSampleOrg";
        $user->Email = "mail@test.com";
        $user->LegalPersonType = \MangoPay\LegalPersonType::Business;
        $user->HeadquartersAddress = $this->getNewAddress();
        $user->LegalRepresentativeFirstName = $john->FirstName;
        $user->LegalRepresentativeLastName = $john->LastName;
        $user->LegalRepresentativeAddress = $john->Address;
        $user->LegalRepresentativeEmail = $john->Email;
        $user->LegalRepresentativeBirthday = $john->Birthday;
        $user->LegalRepresentativeNationality = $john->Nationality;
        $user->LegalRepresentativeCountryOfResidence = $john->CountryOfResidence;
        $this->_api->Users->Create($user, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\UserLegal');
    }

    public function test_GetIdempotencyKey_UsersCreateLegalSca()
    {
        $key = md5(uniqid());
        $this->getMatrixSca("OWNER", true, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\UserLegalSca');
    }

    public function test_GetIdempotencyKey_EnrollUserSca()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $this->_api->Users->Enroll($user->Id, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\UserEnrollmentResult');
    }

    public function test_GetIdempotencyKey_ManageUserConsent()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $this->_api->Users->Enroll($user->Id);
        $this->_api->Users->ManageConsent($user->Id, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\UserConsent');
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsIban()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsIBAN();
        $account->Details->IBAN = 'FR7630004000031234567890143';
        $account->Details->BIC = 'BNPAFRPP';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\BankAccount');
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsGb()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsGB();
        $account->Details->AccountNumber = '63956474';
        $account->Details->SortCode = '200000';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\BankAccount');
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsUs()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsUS();
        $account->Details->AccountNumber = '234234234234';
        $account->Details->ABA = '234334789';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\BankAccount');
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsCa()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsCA();
        $account->Details->BankName = 'TestBankName';
        $account->Details->BranchCode = '12345';
        $account->Details->AccountNumber = '234234234234';
        $account->Details->InstitutionNumber = '123';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\BankAccount');
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsOther()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsOTHER();
        $account->Details->Type = 'OTHER';
        $account->Details->Country = 'FR';
        $account->Details->AccountNumber = '234234234234';
        $account->Details->BIC = 'BINAADADXXX';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\BankAccount');
    }

    public function test_GetIdempotencyKey_ValidateUserDataFormat()
    {
        $key = md5(uniqid());
        $companyNumberDetails = new \MangoPay\CompanyNumberDetails();
        $companyNumber = new \MangoPay\CompanyNumber();
        $companyNumber->CompanyNumber = 'AB123456';
        $companyNumber->CountryCode = 'IT';
        $companyNumberDetails->CompanyNumber = $companyNumber;
        $this->_api->Users->ValidateTheFormatOfUserData($companyNumberDetails, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\CompanyNumberDetails');
    }

    public function test_GetIdempotencyKey_VirtualAccountCreate()
    {
        $key = md5(uniqid());
        $this->getNewVirtualAccount($key);
        $this->assertIdempotencyResource($key, '\MangoPay\VirtualAccount');
    }

    public function test_GetIdempotencyKey_KycDocumentsCreate()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\KycDocument');
    }

    public function test_GetIdempotencyKey_WalletsCreate()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR';
        $this->_api->Wallets->Create($wallet, $key);

        $this->assertIdempotencyResource($key, '\MangoPay\Wallet');
    }

    public function test_GetIdempotencyKey_DisputesCreateDisputeDocument()
    {
        $key = md5(uniqid());
        $document = $this->getNewDisputeDocument($key);
        if (is_null($document)) {
            $this->markTestSkipped("Cannot test creating dispute document because there's no dispute with expected status in the disputes list.");
            return;
        }

        $this->assertIdempotencyResource($key, '\MangoPay\DisputeDocument');
    }

    public function test_GetIdempotencyKey_DisputesCreateSettlementTransfer()
    {
        $this->markTestSkipped("404 not found");

        $key = md5(uniqid());
        $transfer = $this->getNewSettlementTransfer($key);
        if (is_null($transfer)) {
            $this->markTestSkipped("Cannot test creating settlement transfer because there's no closed, not contestable disputes in the disputes list.");
            return;
        }

        $this->assertIdempotencyResource($key, '\MangoPay\Transfer');
    }

    public function test_GetIdempotencyKey_CreateBankAccount()
    {
        $key = md5(uniqid());
        $account = $this->getClientBankAccount();
        $this->_api->Clients->CreateBankAccount($account, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\BankAccount');
    }

    public function test_GetIdempotencyKey_CreatePayOut()
    {
        $key = md5(uniqid());
        $this->createPayOutForClient($key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayOut');
    }

    public function test_GetIdempotencyKey_CreateBankWireDirectPayIn()
    {
        $key = md5(uniqid());
        $payIn = new PayIn();
        $payIn->CreditedWalletId = "CREDIT_EUR";
        $payIn->PaymentDetails = new PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 100;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();

        $this->_api->Clients->CreateBankWireDirectPayIn($payIn, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\PayIn');
    }

    public function test_GetIdempotencyKey_BankingAlias_Create()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR';
        $wallet = $this->_api->Wallets->Create($wallet);

        $this->getJohnsBankingAliasIBAN($wallet, $key);
        $this->assertIdempotencyResource($key, '\MangoPay\BankingAliasIBAN');
    }

    public function test_GetIdempotencyKey_Deposits_Create()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id), $key);
        $this->assertIdempotencyResource($key, '\MangoPay\Deposit');
    }
}
