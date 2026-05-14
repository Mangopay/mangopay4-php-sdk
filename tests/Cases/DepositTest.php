<?php

namespace MangoPay\Tests\Cases;

use MangoPay\CancelDeposit;
use MangoPay\CardPreAuthorizationPaymentStatus;
use MangoPay\CreateCardPreAuthorizedDepositPayIn;
use MangoPay\DepositStatus;
use MangoPay\Money;
use MangoPay\PayInPaymentType;

class DepositTest extends Base
{
    /**
     * @throws \Exception
     */
    public function test_Deposits_Create()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));

        $this->assertNotNull($deposit);
        $this->assertInstanceOf('\MangoPay\Deposit', $deposit);
        $this->assertNotInstanceOf('\MangoPay\PayPalDepositPreauthorization', $deposit);
        $this->assertNotNull($deposit->AuthenticationResult);
    }

    public function test_Deposits_CreatePayPalPreauthorization()
    {
        $user = $this->getJohn();
        $created = $this->_api->Deposits->CreatePayPalDepositPreauthorization(
            $this->getNewPayPalDepositPreauthorization($user->Id)
        );

        $this->assertNotNull($created);
        $this->assertInstanceOf('\MangoPay\PayPalDepositPreauthorization', $created);
        $this->assertNotNull($created->DebitedFunds);
        $this->assertNotNull($created->ReturnURL);
        $this->assertNotNull($created->Reference);
        $this->assertNotNull($created->ShippingPreference);
        $this->assertEquals(PayInPaymentType::PayPal, $created->PaymentType);
        $this->assertEquals(CardPreAuthorizationPaymentStatus::Waiting, $created->PaymentStatus);
        $this->assertEquals(DepositStatus::Created, $created->Status);
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_CheckCardInfo()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));

        $this->assertNotNull($deposit);
        $this->assertInstanceOf('\MangoPay\Deposit', $deposit);
        $this->assertNotInstanceOf('\MangoPay\PayPalDepositPreauthorization', $deposit);
        $this->assertNotNull($deposit->CardInfo);
//        $this->assertNotNull($deposit->CardInfo->Type);
//        $this->assertNotNull($deposit->CardInfo->Brand);
//        $this->assertNotNull($deposit->CardInfo->IssuingBank);
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_Get()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $fetchedDeposit = $this->_api->Deposits->Get($deposit->Id);

        $this->assertEquals($deposit->Id, $fetchedDeposit->Id);
        $this->assertInstanceOf('\MangoPay\Deposit', $fetchedDeposit);
        $this->assertNotInstanceOf('\MangoPay\PayPalDepositPreauthorization', $fetchedDeposit);
    }

    public function test_Deposits_GetPayPalDepositPreauthorization()
    {
        $user = $this->getJohn();
        $created = $this->_api->Deposits->CreatePayPalDepositPreauthorization(
            $this->getNewPayPalDepositPreauthorization($user->Id)
        );
        $fetched = $this->_api->Deposits->Get($created->Id);

        $this->assertNotNull($fetched);
        $this->assertInstanceOf('\MangoPay\PayPalDepositPreauthorization', $fetched);
        $this->assertEquals($created->Id, $fetched->Id);
        $this->assertEquals(PayInPaymentType::PayPal, $fetched->PaymentType);
        $this->assertEquals(CardPreAuthorizationPaymentStatus::Waiting, $fetched->PaymentStatus);
        $this->assertEquals(DepositStatus::Created, $fetched->Status);
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_GetAllForUser()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $this->_api->Deposits->CreatePayPalDepositPreauthorization(
            $this->getNewPayPalDepositPreauthorization($user->Id)
        );
        $fetched = $this->_api->Deposits->GetAllForUser($deposit->AuthorId);


        self::assertNotNull($fetched);
        self::assertTrue(is_array($fetched));
        self::assertTrue(sizeof($fetched) >= 2);

        $foundCard = false;
        $foundPayPal = false;
        foreach ($fetched as $item) {
            self::assertInstanceOf('\MangoPay\Deposit', $item);
            if ($item instanceof \MangoPay\PayPalDepositPreauthorization) {
                $foundPayPal = true;
            } else {
                $foundCard = true;
            }
        }
        self::assertTrue($foundCard, 'Expected at least one card-based Deposit in the list');
        self::assertTrue($foundPayPal, 'Expected at least one PayPalDepositPreauthorization in the list');
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_GetAllForCard()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $fetched = $this->_api->Deposits->GetAllForCard($deposit->CardId);


        self::assertNotNull($fetched);
        self::assertTrue(is_array($fetched));
        self::assertTrue(sizeof($fetched) > 0);
        foreach ($fetched as $item) {
            self::assertInstanceOf('\MangoPay\Deposit', $item);
            self::assertNotInstanceOf('\MangoPay\PayPalDepositPreauthorization', $item);
        }
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_Cancel()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));

        $dto = new CancelDeposit();
        $dto->PaymentStatus = "CANCELED";

        $canceled = $this->_api->Deposits->Cancel($deposit->Id, $dto);

        $fetchedDeposit = $this->_api->Deposits->Get($deposit->Id);

        $this->assertEquals("CANCELED", $fetchedDeposit->PaymentStatus);
        $this->assertInstanceOf('\MangoPay\Deposit', $canceled);
        $this->assertNotInstanceOf('\MangoPay\PayPalDepositPreauthorization', $canceled);
        $this->assertInstanceOf('\MangoPay\Deposit', $fetchedDeposit);
        $this->assertNotInstanceOf('\MangoPay\PayPalDepositPreauthorization', $fetchedDeposit);
    }

    public function test_PayPalDeposits_Cancel()
    {
        $this->markTestSkipped("Deposit must be manually authorized before cancelling");
        $user = $this->getJohn();
        $created = $this->_api->Deposits->CreatePayPalDepositPreauthorization(
            $this->getNewPayPalDepositPreauthorization($user->Id)
        );

        $dto = new CancelDeposit();
        $dto->PaymentStatus = "CANCELED";

        $canceled = $this->_api->Deposits->Cancel($created->Id, $dto);
        $fetchedDeposit = $this->_api->Deposits->Get($created->Id);

        $this->assertEquals("CANCELED", $canceled->PaymentStatus);
        $this->assertEquals("CANCELED", $fetchedDeposit->PaymentStatus);
        $this->assertInstanceOf('\MangoPay\PayPalDepositPreauthorization', $canceled);
        $this->assertInstanceOf('\MangoPay\PayPalDepositPreauthorization', $fetchedDeposit);
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_GetTransactions()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $wallet = $this->getJohnsWallet();

        $dto = new CreateCardPreAuthorizedDepositPayIn();
        $dto->DepositId = $deposit->Id;
        $dto->AuthorId = $user->Id;
        $dto->CreditedWalletId = $wallet->Id;

        $debitedFunds = new Money();
        $debitedFunds->Amount = 1000;
        $debitedFunds->Currency = "EUR";

        $fees = new Money();
        $fees->Amount = 0;
        $fees->Currency = "EUR";

        $dto->DebitedFunds = $debitedFunds;
        $dto->Fees = $fees;

        $this->_api->PayIns->CreateDepositPreauthorizedPayInWithoutComplement($dto);
        sleep(5);
        $transactions = $this->_api->Deposits->GetTransactions($deposit->Id);

        self::assertNotNull($transactions);
        self::assertTrue(is_array($transactions));
        self::assertTrue(sizeof($transactions) > 0);
    }
}
