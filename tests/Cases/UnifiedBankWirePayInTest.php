<?php

namespace MangoPay\Tests\Cases;

use MangoPay\AccountAddress;
use MangoPay\CreditedAccount;
use MangoPay\CreditedAccountInternationalDetails;
use MangoPay\CreditedAccountLocalDetails;
use MangoPay\CurrencyIso;
use MangoPay\DebitedAccount;
use MangoPay\DebitedBankAccount;
use MangoPay\InternationalAccount;
use MangoPay\MangoPayApi;
use MangoPay\Money;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsDirect;
use MangoPay\PayInExecutionDetailsExternalInstruction;
use MangoPay\PayInExecutionType;
use MangoPay\PayInPaymentDetailsBankWire;
use MangoPay\PayInPendingAction;
use MangoPay\PayInPendingActionDetail;
use MangoPay\PayInReferences;
use MangoPay\PayInTransactionDetailsBankWire;
use MangoPay\ReconciliationDetails;
use PHPUnit\Framework\TestCase;

/**
 * Offline tests for the unified bank wire pay-in shape (no API calls).
 */
class UnifiedBankWirePayInTest extends TestCase
{
    private const DIRECT_CREATED = '{"Id":"1","Status":"CREATED","PaymentType":"BANK_WIRE",'
        . '"ExecutionType":"DIRECT","VirtualAccountId":null,"OperationId":"op_123","BankingAliasId":null,'
        . '"DeclaredDebitedFunds":{"Currency":"EUR","Amount":1000},'
        . '"DeclaredFees":{"Currency":"EUR","Amount":0},"WireReference":"REF123",'
        . '"BankAccount":{"Type":"IBAN","IBAN":"FR76","BIC":"BIC","OwnerName":"Mangopay"},'
        . '"CreditedAccount":{"LocalAccountDetails":{"BankName":"B","AccountOwner":"Owner",'
        . '"Address":{"StreetName":"S","PostCode":"P","TownName":"T","CountrySubDivision":null,"Country":"LU"},'
        . '"Account":{"AccountNumber":"123","SortCode":"99"}},'
        . '"InternationalAccountDetails":{"AccountOwner":"Owner","BankName":null,'
        . '"Account":{"Iban":"LU28","Bic":"BICX"},'
        . '"Address":{"StreetName":"S","PostCode":"P","TownName":"T","Country":"LU"}}},'
        . '"DebitedAccount":null,"ReconciliationDetails":null,'
        . '"PendingAction":{"Action":"PAYMENT_REQUIRED","ActionDetails":[{"UserId":"user_123"}],'
        . '"ExpiryDate":1900000000}}';

    private const VIRTUAL_ACCOUNT_SUCCEEDED = '{"Id":"2","Status":"SUCCEEDED","PaymentType":"BANK_WIRE",'
        . '"ExecutionType":"EXTERNAL_INSTRUCTION","VirtualAccountId":"VA1","BankingAliasId":"VA1",'
        . '"WireReference":"WR","CreditedAccount":null,'
        . '"DebitedAccount":{"AccountOwner":"Debtor","BankAccount":"FR1","BankCode":"BNPA",'
        . '"AddressLine1":"L1","AddressLine2":null,"AddressLine3":null},'
        . '"DebitedBankAccount":{"OwnerName":"Debtor","IBAN":"FR1"},'
        . '"ReconciliationDetails":{"MatchedFunds":null,"ReceivedFunds":null,'
        . '"ReceivedWireReference":"WR"},'
        . '"TransactionDetails":[{"DebtorName":"Debtor","References":[{"Type":"EndToEndId","Value":"E2E-1"}]}]}';

    /** @var MangoPayApi */
    private $api;

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new MangoPayApi();
    }

    public function test_DirectBankWireCreated()
    {
        $payIn = $this->castPayIn(self::DIRECT_CREATED);
        /** @var PayInPaymentDetailsBankWire $d */
        $d = $payIn->PaymentDetails;

        $this->assertInstanceOf(PayInPaymentDetailsBankWire::class, $d);
        $this->assertInstanceOf(PayInExecutionDetailsDirect::class, $payIn->ExecutionDetails);
        $this->assertEquals('REF123', $d->WireReference);
        $this->assertEquals(1000, $d->DeclaredDebitedFunds->Amount);
        $this->assertNull($d->VirtualAccountId);
        $this->assertNull($d->DebitedAccount);
        $this->assertNull($d->ReconciliationDetails);
        $this->assertEquals('op_123', $d->OperationId);

        $this->assertInstanceOf(PayInPendingAction::class, $d->PendingAction);
        $this->assertEquals('PAYMENT_REQUIRED', $d->PendingAction->Action);
        $this->assertEquals(1900000000, $d->PendingAction->ExpiryDate);
        $this->assertCount(1, $d->PendingAction->ActionDetails);
        $this->assertInstanceOf(PayInPendingActionDetail::class, $d->PendingAction->ActionDetails[0]);
        $this->assertEquals('user_123', $d->PendingAction->ActionDetails[0]->UserId);

        $this->assertInstanceOf(CreditedAccount::class, $d->CreditedAccount);
        $local = $d->CreditedAccount->LocalAccountDetails;
        $this->assertInstanceOf(CreditedAccountLocalDetails::class, $local);
        $this->assertEquals('Owner', $local->AccountOwner);
        $this->assertInstanceOf(AccountAddress::class, $local->Address);
        $this->assertEquals('T', $local->Address->TownName);
        $this->assertEquals('123', $local->Account->AccountNumber);

        $intl = $d->CreditedAccount->InternationalAccountDetails;
        $this->assertInstanceOf(CreditedAccountInternationalDetails::class, $intl);
        $this->assertInstanceOf(InternationalAccount::class, $intl->Account);
        $this->assertEquals('LU28', $intl->Account->Iban);
    }

    public function test_VirtualAccountBankWireSucceeded()
    {
        $payIn = $this->castPayIn(self::VIRTUAL_ACCOUNT_SUCCEEDED);
        /** @var PayInPaymentDetailsBankWire $d */
        $d = $payIn->PaymentDetails;
        /** @var PayInExecutionDetailsExternalInstruction $e */
        $e = $payIn->ExecutionDetails;

        $this->assertInstanceOf(PayInExecutionDetailsExternalInstruction::class, $e);
        $this->assertEquals('VA1', $d->VirtualAccountId);
        $this->assertEquals('VA1', $e->BankingAliasId);
        $this->assertEquals('WR', $e->WireReference);
        $this->assertNull($d->CreditedAccount);

        $this->assertInstanceOf(DebitedAccount::class, $d->DebitedAccount);
        $this->assertEquals('Debtor', $d->DebitedAccount->AccountOwner);
        $this->assertEquals('BNPA', $d->DebitedAccount->BankCode);

        $this->assertInstanceOf(DebitedBankAccount::class, $d->DebitedBankAccount);
        $this->assertEquals('FR1', $d->DebitedBankAccount->IBAN);

        $this->assertInstanceOf(ReconciliationDetails::class, $d->ReconciliationDetails);
        $this->assertNull($d->ReconciliationDetails->ReceivedFunds);
        $this->assertNull($d->ReconciliationDetails->MatchedFunds);
        $this->assertEquals('WR', $d->ReconciliationDetails->ReceivedWireReference);

        $this->assertCount(1, $d->TransactionDetails);
        $this->assertInstanceOf(PayInTransactionDetailsBankWire::class, $d->TransactionDetails[0]);
        $this->assertInstanceOf(PayInReferences::class, $d->TransactionDetails[0]->References[0]);
        $this->assertEquals('EndToEndId', $d->TransactionDetails[0]->References[0]->Type);
        $this->assertEquals('E2E-1', $d->TransactionDetails[0]->References[0]->Value);
    }

    public function test_SerializesFieldsBuiltWithProperties()
    {
        $localAddress = new AccountAddress();
        $localAddress->StreetName = '1 Main St';
        $localAddress->PostCode = 'EC1A';
        $localAddress->TownName = 'London';
        $localAddress->CountrySubDivision = 'ENG';
        $localAddress->Country = 'GB';

        $local = new CreditedAccountLocalDetails();
        $local->BankName = 'Local Bank';
        $local->AccountOwner = 'Local Owner';
        $local->Address = $localAddress;
        $local->Account = ['AccountNumber' => '11696419', 'SortCode' => '010039'];

        $intlAccount = new InternationalAccount();
        $intlAccount->Iban = 'LU29';
        $intlAccount->Bic = 'BICY';
        $intlAddress = new AccountAddress();
        $intlAddress->TownName = 'Luxembourg';
        $intlAddress->Country = 'LU';

        $intl = new CreditedAccountInternationalDetails();
        $intl->AccountOwner = 'Intl Owner';
        $intl->BankName = 'Intl Bank';
        $intl->Account = $intlAccount;
        $intl->Address = $intlAddress;

        $credited = new CreditedAccount();
        $credited->LocalAccountDetails = $local;
        $credited->InternationalAccountDetails = $intl;

        $debited = new DebitedAccount();
        $debited->AccountOwner = 'John Doe';
        $debited->BankAccount = 'GB33';
        $debited->BankCode = 'BUKB';
        $debited->AddressLine1 = 'L1';
        $debited->AddressLine2 = 'L2';
        $debited->AddressLine3 = 'L3';

        $pendingAction = new PayInPendingAction();
        $pendingAction->Action = 'PAYMENT_REQUIRED';
        $actionDetail = new PayInPendingActionDetail();
        $actionDetail->UserId = 'user_1';
        $pendingAction->ActionDetails = [$actionDetail];
        $pendingAction->ExpiryDate = 1900000000;

        $reconciliation = new ReconciliationDetails();
        $reconciliation->MatchedFunds = $this->money(500);
        $reconciliation->ReceivedFunds = $this->money(600);
        $reconciliation->ReceivedWireReference = 'RWR';

        $debitedBankAccount = new DebitedBankAccount();
        $debitedBankAccount->OwnerName = 'John Doe';
        $debitedBankAccount->IBAN = 'GB33';

        $details = new PayInPaymentDetailsBankWire();
        $details->VirtualAccountId = 'VA1';
        $details->OperationId = 'op_1';
        $details->CreditedAccount = $credited;
        $details->DebitedAccount = $debited;
        $details->PendingAction = $pendingAction;
        $details->ReconciliationDetails = $reconciliation;
        $details->DebitedBankAccount = $debitedBankAccount;

        $payIn = new PayIn();
        $payIn->PaymentDetails = $details;
        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();

        $out = json_decode(json_encode($this->buildRequestData($payIn)));

        $this->assertEquals('VA1', $out->VirtualAccountId);
        $this->assertEquals('op_1', $out->OperationId);

        $outLocal = $out->CreditedAccount->LocalAccountDetails;
        $this->assertEquals('Local Bank', $outLocal->BankName);
        $this->assertEquals('Local Owner', $outLocal->AccountOwner);
        $this->assertEquals('010039', $outLocal->Account->SortCode);
        $this->assertEquals('1 Main St', $outLocal->Address->StreetName);
        $this->assertEquals('EC1A', $outLocal->Address->PostCode);
        $this->assertEquals('London', $outLocal->Address->TownName);
        $this->assertEquals('ENG', $outLocal->Address->CountrySubDivision);
        $this->assertEquals('GB', $outLocal->Address->Country);

        $outIntl = $out->CreditedAccount->InternationalAccountDetails;
        $this->assertEquals('Intl Owner', $outIntl->AccountOwner);
        $this->assertEquals('Intl Bank', $outIntl->BankName);
        $this->assertEquals('LU29', $outIntl->Account->Iban);
        $this->assertEquals('BICY', $outIntl->Account->Bic);
        $this->assertEquals('Luxembourg', $outIntl->Address->TownName);

        $this->assertEquals('John Doe', $out->DebitedAccount->AccountOwner);
        $this->assertEquals('GB33', $out->DebitedAccount->BankAccount);
        $this->assertEquals('BUKB', $out->DebitedAccount->BankCode);
        $this->assertEquals('L1', $out->DebitedAccount->AddressLine1);
        $this->assertEquals('L2', $out->DebitedAccount->AddressLine2);
        $this->assertEquals('L3', $out->DebitedAccount->AddressLine3);

        $this->assertEquals('PAYMENT_REQUIRED', $out->PendingAction->Action);
        $this->assertEquals(1900000000, $out->PendingAction->ExpiryDate);
        $this->assertEquals('user_1', $out->PendingAction->ActionDetails[0]->UserId);

        $this->assertEquals(500, $out->ReconciliationDetails->MatchedFunds->Amount);
        $this->assertEquals(600, $out->ReconciliationDetails->ReceivedFunds->Amount);
        $this->assertEquals('RWR', $out->ReconciliationDetails->ReceivedWireReference);

        $this->assertEquals('GB33', $out->DebitedBankAccount->IBAN);
    }

    public function test_SerializesDirectBankWireResponse()
    {
        $payIn = $this->castPayIn(self::DIRECT_CREATED);
        $out = json_decode(json_encode($this->buildRequestData($payIn)));

        $this->assertEquals('op_123', $out->OperationId);
        $this->assertEquals('PAYMENT_REQUIRED', $out->PendingAction->Action);
        $this->assertEquals(1900000000, $out->PendingAction->ExpiryDate);
        $this->assertEquals('user_123', $out->PendingAction->ActionDetails[0]->UserId);
        $this->assertEquals('Owner', $out->CreditedAccount->LocalAccountDetails->AccountOwner);
        $this->assertEquals('99', $out->CreditedAccount->LocalAccountDetails->Account->SortCode);
        $this->assertEquals('LU28', $out->CreditedAccount->InternationalAccountDetails->Account->Iban);
        $this->assertObjectNotHasProperty('DebitedAccount', $out);
        $this->assertObjectNotHasProperty('ReconciliationDetails', $out);
    }

    public function test_DocsExampleDirect()
    {
        $payIn = $this->castPayIn($this->fixture('unified_bank_wire_payin_direct.json'));
        $this->assertEquals(PayInExecutionType::Direct, $payIn->ExecutionType);
        /** @var PayInPaymentDetailsBankWire $d */
        $d = $payIn->PaymentDetails;

        $this->assertNull($d->VirtualAccountId);
        $this->assertNull($d->PendingAction);
        $this->assertNull($d->OperationId);
        $this->assertEquals('MG4liawppe', $d->WireReference);
        $this->assertEquals(200000, $d->DeclaredDebitedFunds->Amount);
        $this->assertEquals('MANGOPAY SA', $d->BankAccount->OwnerName);

        $this->assertEquals('John Doe', $d->DebitedBankAccount->OwnerName);
        $this->assertEquals('GB33BUKB20201555555555', $d->DebitedBankAccount->IBAN);

        $this->assertNull($d->CreditedAccount->LocalAccountDetails);
        $intl = $d->CreditedAccount->InternationalAccountDetails;
        $this->assertEquals('MANGOPAY SA', $intl->AccountOwner);
        $this->assertNull($intl->BankName);
        $this->assertEquals('FR7630056009271234567890182', $intl->Account->Iban);
        $this->assertEquals('CCFRFRPPXXX', $intl->Account->Bic);
        $this->assertEquals('Luxembourg', $intl->Address->TownName);
        $this->assertEquals('L-1125', $intl->Address->PostCode);

        $debited = $d->DebitedAccount;
        $this->assertEquals('John Doe', $debited->AccountOwner);
        $this->assertEquals('GB33BUKB20201555555555', $debited->BankAccount);
        $this->assertEquals('BUKBGB22XXX', $debited->BankCode);
        $this->assertEquals('75006 - FR', $debited->AddressLine3);

        $rec = $d->ReconciliationDetails;
        $this->assertEquals(200000, $rec->MatchedFunds->Amount);
        $this->assertEquals(200000, $rec->ReceivedFunds->Amount);
        $this->assertEquals('MG4liawppe', $rec->ReceivedWireReference);

        $tx = $d->TransactionDetails[0];
        $this->assertEquals('PMNT', $tx->BankTransactionDomainCode);
        $this->assertEquals('EndToEndId', $tx->References[0]->Type);
        $this->assertEquals('AAB.123.EU.ABC-00012345', $tx->References[0]->Value);
        $this->assertEquals('MG4liawppe', $tx->RemittanceInformationLine1);
    }

    public function test_DocsExampleVirtualAccount()
    {
        $payIn = $this->castPayIn($this->fixture('unified_bank_wire_payin_virtual_account.json'));
        $this->assertEquals(PayInExecutionType::ExternalInstruction, $payIn->ExecutionType);
        /** @var PayInPaymentDetailsBankWire $d */
        $d = $payIn->PaymentDetails;
        /** @var PayInExecutionDetailsExternalInstruction $e */
        $e = $payIn->ExecutionDetails;

        $this->assertEquals('wltbank_01M6RQFNJH8BV6KK80VKBKCF09', $d->VirtualAccountId);
        $this->assertEquals($d->VirtualAccountId, $e->BankingAliasId);
        $this->assertEquals('MGqe0u9b94 Wire Reference 123', $d->WireReference);
        $this->assertEquals($d->WireReference, $e->WireReference);
        $this->assertEquals('Tom Donaldson', $e->DebitedBankAccount->OwnerName);
        $this->assertNull($d->CreditedAccount);
        $this->assertNull($d->PendingAction);
        $this->assertEquals('Tom Donaldson', $d->DebitedBankAccount->OwnerName);

        $this->assertEquals('Tom Donaldson', $d->DebitedAccount->AccountOwner);
        $this->assertEquals('COBADEFFXXX', $d->DebitedAccount->BankCode);
        $this->assertNull($d->DebitedAccount->AddressLine1);

        $this->assertNull($d->ReconciliationDetails->MatchedFunds);
        $this->assertNull($d->ReconciliationDetails->ReceivedFunds);
        $this->assertEquals('MGqe0u9b94 Wire Reference 123', $d->ReconciliationDetails->ReceivedWireReference);

        $tx = $d->TransactionDetails[0];
        $this->assertEquals('EndToEndId', $tx->References[0]->Type);
        $this->assertNull($tx->References[0]->Value);
        $this->assertEquals('123', $tx->RemittanceInformationLine4);

        $this->assertNull($d->DeclaredDebitedFunds);
        $this->assertNull($d->BankAccount);
    }

    /**
     * @param string $json
     * @return PayIn
     */
    private function castPayIn($json)
    {
        $method = new \ReflectionMethod($this->api->PayIns, 'CastResponseToEntity');
        $method->setAccessible(true);

        return $method->invoke($this->api->PayIns, json_decode($json), '\MangoPay\PayIn');
    }

    private function buildRequestData($entity)
    {
        $method = new \ReflectionMethod($this->api->PayIns, 'BuildRequestData');
        $method->setAccessible(true);

        return $method->invoke($this->api->PayIns, $entity);
    }

    private function fixture($name)
    {
        $path = __DIR__ . '/../' . $name;
        $this->assertFileExists($path, 'missing test resource ' . $name);

        return file_get_contents($path);
    }

    private function money($amount)
    {
        $money = new Money();
        $money->Amount = $amount;
        $money->Currency = CurrencyIso::EUR;

        return $money;
    }
}
