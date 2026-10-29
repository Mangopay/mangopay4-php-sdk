<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for refunds
 */
class RefundsTest extends Base
{
    public function test_Refund_GetForTransfer()
    {
        $transfer = $this->getNewTransfer();
        $refund = $this->getNewRefundForTransfer($transfer);
        $user = $this->getJohnPayer();

        $getRefund = $this->_api->Refunds->Get($refund->Id);

        $this->assertEquals($refund->Id, $getRefund->Id);
        $this->assertEquals($transfer->Id, $getRefund->InitialTransactionId);
        $this->assertEquals($user->Id, $getRefund->AuthorId);
        $this->assertEquals('TRANSFER', $getRefund->Type);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $getRefund->RefundReason);
    }

    public function test_Refund_GetForPayIn()
    {
        $payIn = $this->getNewPayInCardDirect();
        $refund = $this->getNewRefundForPayIn($payIn);
        $user = $this->getJohnPayer();

        $getRefund = $this->_api->Refunds->Get($refund->Id);

        $this->assertEquals($refund->Id, $getRefund->Id);
        $this->assertEquals($payIn->Id, $getRefund->InitialTransactionId);
        $this->assertEquals($user->Id, $getRefund->AuthorId);
        $this->assertEquals('PAYOUT', $getRefund->Type);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $getRefund->RefundReason);
    }
}
