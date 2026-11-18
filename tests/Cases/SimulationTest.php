<?php

namespace MangoPay\Tests\Cases;

use MangoPay\BankWireFundingSimulation;
use MangoPay\BankWireFundingSimulationCreditor;
use MangoPay\BankWireFundingSimulationTransactionDetails;
use MangoPay\BankWirePayInSimulation;
use MangoPay\Libraries\ResponseException;
use MangoPay\Money;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsDirect;
use MangoPay\PayInPaymentDetailsBankWire;
use MangoPay\PayInStatus;

/**
 * Tests for the Sandbox simulation endpoints
 */
class SimulationTest extends Base
{
    public function test_SimulateBankWirePayIn_Accept()
    {
        $payIn = $this->createBankWireDirectPayIn();
        $this->assertEquals(PayInStatus::Created, $payIn->Status);

        $this->_api->Simulations->SimulateBankWirePayIn($payIn->Id, $this->getBankWirePayInSimulation('ACCEPT'));

        $fetched = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals(PayInStatus::Succeeded, $fetched->Status);
    }

    public function test_SimulateBankWirePayIn_Reject()
    {
        $payIn = $this->createBankWireDirectPayIn();
        $this->assertEquals(PayInStatus::Created, $payIn->Status);

        $this->_api->Simulations->SimulateBankWirePayIn($payIn->Id, $this->getBankWirePayInSimulation('REJECT'));

        $fetched = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals(PayInStatus::Failed, $fetched->Status);
        $this->assertEquals('008500', $fetched->ResultCode);
    }

    public function test_SimulateBankWirePayIn_NotFound()
    {
        try {
            $this->_api->Simulations->SimulateBankWirePayIn(
                'payin_wf_does_not_exist',
                $this->getBankWirePayInSimulation('ACCEPT')
            );
            $this->fail('Expected a ResponseException');
        } catch (ResponseException $e) {
            $this->assertEquals(404, $e->getCode());
        }
    }

    public function test_SimulateBankWireFunding()
    {
        $virtualAccount = $this->getNewVirtualAccount();
        $account = $virtualAccount->LocalAccountDetails->Account;

        $creditedFunds = new Money();
        $creditedFunds->Amount = 1260;
        $creditedFunds->Currency = 'EUR';

        $transactionDetails = new BankWireFundingSimulationTransactionDetails();
        $transactionDetails->DebtorName = 'John Doe';
        $transactionDetails->DebtorAccount = 'FR7630004000031234567890143';
        $transactionDetails->DebtorAgent = 'BNPAFRPPXXX';
        $transactionDetails->RemittanceInformationLine1 = 'PHP SDK';
        $transactionDetails->RemittanceInformationLine2 = 'funding simulation';

        $creditor = new BankWireFundingSimulationCreditor();
        $creditor->CreditorAccount = $account->Iban;
        $creditor->CreditorAgent = [$account->Bic];

        $simulation = new BankWireFundingSimulation();
        $simulation->CreditedFunds = $creditedFunds;
        $simulation->Creditor = $creditor;
        $simulation->TransactionDetails = $transactionDetails;

        $this->_api->Simulations->SimulateBankWireFunding($simulation);
        $this->addToAssertionCount(1);
    }

    /**
     * @param string $action ACCEPT or REJECT
     * @return BankWirePayInSimulation
     */
    private function getBankWirePayInSimulation($action)
    {
        $simulation = new BankWirePayInSimulation();
        $simulation->Action = $action;

        return $simulation;
    }

    /**
     * @return PayIn
     */
    private function createBankWireDirectPayIn()
    {
        $wallet = $this->getPredefinedJohnsOwnerScaWallet();

        $payIn = new PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $this::PREDEFINED_USER_NATURAL_OWNER_ACTIVE_REGULAR_SCA;
        $payIn->PaymentDetails = new PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 1000;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->PaymentDetails->DeclaredFees = new Money();
        $payIn->PaymentDetails->DeclaredFees->Amount = 0;
        $payIn->PaymentDetails->DeclaredFees->Currency = 'EUR';
        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();

        return $this->_api->PayIns->Create($payIn);
    }
}
