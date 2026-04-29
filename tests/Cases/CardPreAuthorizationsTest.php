<?php

namespace MangoPay\Tests\Cases;

use MangoPay\AVSResult;
use MangoPay\BrowserInfo;
use MangoPay\Shipping;

/**
 * Tests methods for pay-ins
 */
class CardPreAuthorizationsTest extends Base
{
    public function test_CardPreAuthorization_Create()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();

        $this->assertNotNull($cardPreAuthorization->Id);
        $this->assertSame(\MangoPay\CardPreAuthorizationStatus::Succeeded, $cardPreAuthorization->Status);
        $this->assertSame(\MangoPay\CardPreAuthorizationPaymentStatus::Waiting, $cardPreAuthorization->PaymentStatus);
        $this->assertSame('DIRECT', $cardPreAuthorization->ExecutionType);
        $this->assertNull($cardPreAuthorization->PayInId);
        $this->assertNotNull($cardPreAuthorization->RemainingFunds);
        $this->assertNotNull($cardPreAuthorization->AuthenticationResult);
        $this->assertSame(AVSResult::NO_CHECK, $cardPreAuthorization->SecurityInfo->AVSResult);
        $this->assertInstanceOf(BrowserInfo::class, $cardPreAuthorization->BrowserInfo);
        $this->assertInstanceOf(Shipping::class, $cardPreAuthorization->Shipping);
    }

    public function test_CardPreAuthorization_Get()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();

        $getCardPreAuthorization = $this->_api->CardPreAuthorizations->Get($cardPreAuthorization->Id);

        $this->assertSame($getCardPreAuthorization->Id, $cardPreAuthorization->Id);
        $this->assertSame('000000', $getCardPreAuthorization->ResultCode);
        $this->assertNotNull($getCardPreAuthorization->RemainingFunds);
    }

    public function test_CardPreAuthorization_CheckCardInfo()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();

        $getCardPreAuthorization = $this->_api->CardPreAuthorizations->Get($cardPreAuthorization->Id);

        $this->assertNotNull($getCardPreAuthorization->CardInfo);
//        $this->assertNotNull($getCardPreAuthorization->CardInfo->Type);
//        $this->assertNotNull($getCardPreAuthorization->CardInfo->Brand);
//        $this->assertNotNull($getCardPreAuthorization->CardInfo->IssuingBank);
    }


//    function test_CardPreAuthorization_Update()
//    {
        //TO BE FIXED
        /* $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $cardPreAuthorization->PaymentStatus = \MangoPay\CardPreAuthorizationPaymentStatus::Canceled;

        $resultCardPreAuthorization = $this->_api->CardPreAuthorizations->Update($cardPreAuthorization);

        $this->assertSame(\MangoPay\CardPreAuthorizationStatus::Succeeded, $resultCardPreAuthorization->Status);
        $this->assertSame(\MangoPay\CardPreAuthorizationPaymentStatus::Canceled, $resultCardPreAuthorization->PaymentStatus);

        */
//    }
}
