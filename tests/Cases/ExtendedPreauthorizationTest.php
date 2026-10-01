<?php

namespace MangoPay\Tests\Cases;

use MangoPay\CardPreAuthorizationPaymentStatus;
use MangoPay\CreatePreAuthorizedExtendedPayIn;
use MangoPay\ExtendedPreauthorization;
use MangoPay\ExtendedPreauthorizationStatus;
use MangoPay\Money;
use MangoPay\PayInPaymentType;

class ExtendedPreauthorizationTest extends Base
{
    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_Create()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );

        $this->assertNotNull($extendedPreauthorization);
        $this->assertInstanceOf('\MangoPay\ExtendedPreauthorization', $extendedPreauthorization);
        $this->assertNotInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $extendedPreauthorization);
        $this->assertNotNull($extendedPreauthorization->AuthenticationResult);
        $this->assertNotNull($extendedPreauthorization->FlowDescriptor);
    }

    public function test_ExtendedPreauthorizations_CreatePayPalPreauthorization()
    {
        $user = $this->getJohn();
        $created = $this->_api->ExtendedPreauthorizations->CreatePayPalExtendedPreauthorization(
            $this->getNewPayPalExtendedPreauthorization($user->Id)
        );

        $this->assertNotNull($created);
        $this->assertInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $created);
        $this->assertNotNull($created->DebitedFunds);
        $this->assertNotNull($created->ReturnURL);
        $this->assertNotNull($created->Reference);
        $this->assertNotNull($created->ShippingPreference);
        $this->assertEquals(PayInPaymentType::PayPal, $created->PaymentType);
        $this->assertEquals(CardPreAuthorizationPaymentStatus::Waiting, $created->PaymentStatus);
        $this->assertEquals(ExtendedPreauthorizationStatus::Created, $created->Status);
        $this->assertNotNull($created->FlowDescriptor);
    }

    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_CheckCardInfo()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );

        $this->assertNotNull($extendedPreauthorization);
        $this->assertInstanceOf('\MangoPay\ExtendedPreauthorization', $extendedPreauthorization);
        $this->assertNotInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $extendedPreauthorization);
        $this->assertNotNull($extendedPreauthorization->CardInfo);
    }

    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_Get()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );
        $fetched = $this->_api->ExtendedPreauthorizations->Get($extendedPreauthorization->Id);

        $this->assertEquals($extendedPreauthorization->Id, $fetched->Id);
        $this->assertInstanceOf('\MangoPay\ExtendedPreauthorization', $fetched);
        $this->assertNotInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $fetched);
    }

    public function test_ExtendedPreauthorizations_GetPayPalPreauthorization()
    {
        $user = $this->getJohn();
        $created = $this->_api->ExtendedPreauthorizations->CreatePayPalExtendedPreauthorization(
            $this->getNewPayPalExtendedPreauthorization($user->Id)
        );
        $fetched = $this->_api->ExtendedPreauthorizations->Get($created->Id);

        $this->assertNotNull($fetched);
        $this->assertInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $fetched);
        $this->assertEquals($created->Id, $fetched->Id);
        $this->assertEquals(PayInPaymentType::PayPal, $fetched->PaymentType);
        $this->assertEquals(CardPreAuthorizationPaymentStatus::Waiting, $fetched->PaymentStatus);
        $this->assertEquals(ExtendedPreauthorizationStatus::Created, $fetched->Status);
    }

    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_GetAllForUser()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );
        $this->_api->ExtendedPreauthorizations->CreatePayPalExtendedPreauthorization(
            $this->getNewPayPalExtendedPreauthorization($user->Id)
        );
        $fetched = $this->_api->ExtendedPreauthorizations->GetAllForUser($extendedPreauthorization->AuthorId);

        self::assertNotNull($fetched);
        self::assertTrue(is_array($fetched));
        self::assertTrue(sizeof($fetched) >= 2);

        $foundCard = false;
        $foundPayPal = false;
        foreach ($fetched as $item) {
            self::assertInstanceOf('\MangoPay\ExtendedPreauthorization', $item);
            if ($item instanceof \MangoPay\PayPalExtendedPreauthorization) {
                $foundPayPal = true;
            } else {
                $foundCard = true;
            }
        }
        self::assertTrue($foundCard, 'Expected at least one card-based ExtendedPreauthorization in the list');
        self::assertTrue($foundPayPal, 'Expected at least one PayPalExtendedPreauthorization in the list');
    }

    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_GetAllForCard()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);

        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );
        $fetched = $this->_api->ExtendedPreauthorizations->GetAllForCard($extendedPreauthorization->CardId);

        self::assertNotNull($fetched);
        self::assertTrue(is_array($fetched));
        self::assertTrue(sizeof($fetched) > 0);
        foreach ($fetched as $item) {
            self::assertInstanceOf('\MangoPay\ExtendedPreauthorization', $item);
            self::assertNotInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $item);
        }
    }

    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_Cancel()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );

        $dto = new ExtendedPreauthorization();
        $dto->Id = $extendedPreauthorization->Id;
        $dto->PaymentStatus = "CANCELED";

        $canceled = $this->_api->ExtendedPreauthorizations->Update($dto);

        $fetched = $this->_api->ExtendedPreauthorizations->Get($extendedPreauthorization->Id);

        $this->assertEquals("CANCELED", $fetched->PaymentStatus);
        $this->assertInstanceOf('\MangoPay\ExtendedPreauthorization', $canceled);
        $this->assertNotInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $canceled);
        $this->assertInstanceOf('\MangoPay\ExtendedPreauthorization', $fetched);
        $this->assertNotInstanceOf('\MangoPay\PayPalExtendedPreauthorization', $fetched);
    }

    /**
     * @throws \Exception
     */
    public function test_ExtendedPreauthorizations_GetTransactions()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $extendedPreauthorization = $this->_api->ExtendedPreauthorizations->Create(
            $this->getNewExtendedPreauthorization($cardRegistration->CardId, $user->Id)
        );
        $wallet = $this->getJohnsWallet();

        $dto = new CreatePreAuthorizedExtendedPayIn();
        $dto->ExtendedPreauthorizationId = $extendedPreauthorization->Id;
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

        $this->_api->PayIns->CreatePayInExtendedPreauthorized($dto);
        sleep(5);
        $transactions = $this->_api->ExtendedPreauthorizations->GetTransactions($extendedPreauthorization->Id);

        self::assertNotNull($transactions);
        self::assertTrue(is_array($transactions));
        self::assertTrue(sizeof($transactions) > 0);
    }
}
