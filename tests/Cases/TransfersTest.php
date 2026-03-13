<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Money;
use MangoPay\TransactionStatus;
use MangoPay\Transfer;

/**
 * Tests basic methods for transfers
 */
class TransfersTest extends Base
{
    public function test_Transfers_Create()
    {
        $john = $this->getJohn();

        $transfer = $this->getNewTransfer();
        $creditedWallet = $this->_api->Wallets->Get($transfer->CreditedWalletId);

        $this->assertNotNull($transfer->Id);
        $this->assertEquals($john->Id, $transfer->AuthorId);
        $this->assertEquals($john->Id, $transfer->CreditedUserId);
        $this->assertEquals(100, $creditedWallet->Balance->Amount);
    }

    public function test_Transfers_Create_Sca()
    {
        $user = $this->getJohnSca("OWNER", false);
        $walletWithMoney = $this->getNewWalletWithMoney($user->Id, 10000);
        $transferUserPresent = $this->getNewTransferSca($user->Id, 3001, 'USER_PRESENT', $walletWithMoney->Id);
        $transferUserPresentLowAmount = $this->getNewTransferSca($user->Id, 20, 'USER_PRESENT', $walletWithMoney->Id);
        $transferUserNotPresent = $this->getNewTransferSca($user->Id, 3001, 'USER_NOT_PRESENT', $walletWithMoney->Id);

        $this->assertEquals(TransactionStatus::Succeeded, $transferUserPresent->Status);
//        $this->assertNotNull($transferUserPresent->PendingUserAction);

        $this->assertEquals(TransactionStatus::Succeeded, $transferUserPresentLowAmount->Status);
        $this->assertNull($transferUserPresentLowAmount->PendingUserAction);

        $this->assertEquals(TransactionStatus::Succeeded, $transferUserNotPresent->Status);
        $this->assertNull($transferUserNotPresent->PendingUserAction);
    }

    public function test_Transfers_Get()
    {
        $john = $this->getJohn();
        $transfer = $this->getNewTransfer();

        $getTransfer = $this->_api->Transfers->Get($transfer->Id);

        $this->assertSame($transfer->Id, $getTransfer->Id);
        $this->assertEquals($john->Id, $getTransfer->AuthorId);
        $this->assertEquals($john->Id, $getTransfer->CreditedUserId);
        $this->assertIdenticalInputProps($transfer, $getTransfer);
    }

    public function test_Transfers_CreateRefund()
    {
        $transfer = $this->getNewTransfer();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);

        $refund = $this->getNewRefundForTransfer($transfer);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertNotNull($refund->Id);
        $this->assertSame($refund->DebitedFunds->Amount, $transfer->DebitedFunds->Amount);
        $this->assertEquals($walletBefore->Balance->Amount, $walletAfter->Balance->Amount - $transfer->DebitedFunds->Amount);
        $this->assertEquals('TRANSFER', $refund->Type);
        $this->assertEquals('REFUND', $refund->Nature);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $refund->RefundReason);
    }

    public function test_Transfer_GetRefunds()
    {
        $transfer = $this->getNewTransfer();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterRefunds();

        $refunds = $this->_api->Transfers->GetRefunds($transfer->Id, $pagination, $filter);

        $this->assertNotNull($refunds);
        $this->assertTrue(is_array($refunds), 'Expected an array');
    }

    public function test_Transfer_Create()
    {
        $john = $this->getJohn();
        $debitedWallet = $this->getJohnsWalletWithMoney();
        $creditedWallet = $this->getJohnsWallet();
        $transfer = new Transfer();
        $transfer->AuthorId = $john->Id;
        $transfer->CreditedUserId = $john->Id;
        $transfer->DebitedFunds = new Money();
        $transfer->DebitedFunds->Currency = "EUR";
        $transfer->DebitedFunds->Amount = 10;
        $transfer->Fees = new Money();
        $transfer->Fees->Currency = "EUR";
        $transfer->Fees->Amount = 0;
        $transfer->DebitedWalletId = $debitedWallet->Id;
        $transfer->CreditedWalletId = $creditedWallet->Id;

        $result = $this->_api->Transfers->Create($transfer);

        $this->assertNotNull($result);
        $this->assertEquals($transfer->DebitedFunds->Currency, $creditedWallet->Currency);
        $this->assertEquals($transfer->Fees->Currency, $creditedWallet->Currency);
    }
}
