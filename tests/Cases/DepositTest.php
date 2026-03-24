<?php

namespace MangoPay\Tests\Cases;

use MangoPay\CancelDeposit;
use MangoPay\CreateCardPreAuthorizedDepositPayIn;
use MangoPay\Money;

/**
 * Tests basic methods for disputes
 */
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
        $this->assertNotNull($deposit->AuthenticationResult);
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
    }

    /**
     * @throws \Exception
     */
    public function test_Deposits_GetAllForUser()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $fetched = $this->_api->Deposits->GetAllForUser($deposit->AuthorId);


        self::assertNotNull($fetched);
        self::assertTrue(is_array($fetched));
        self::assertTrue(sizeof($fetched) > 0);
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

        $this->_api->Deposits->Cancel($deposit->Id, $dto);

        $fetchedDeposit = $this->_api->Deposits->Get($deposit->Id);

        $this->assertEquals("CANCELED", $fetchedDeposit->PaymentStatus);
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
