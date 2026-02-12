<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for Virtual Accounts
 */
class VirtualAccountsTest extends Base
{
    /**
     * @var \MangoPay\VirtualAccount
     */
    public static $johnsVirtualAccount;

    public function test_VirtualAccount_Create()
    {
        $virtualAccount = $this->getNewVirtualAccount();
        $wallet = $this->getJohnsWallet();

        $this->assertNotNull($virtualAccount);
        $this->assertEquals($virtualAccount->WalletId, $wallet->Id);
        $this->assertEquals("Success", $virtualAccount->ResultMessage);
        $this->assertEquals("000000", $virtualAccount->ResultCode);
        $this->assertNotNull($virtualAccount->LocalAccountDetails->BankName);
    }

    public function test_VirtualAccount_Get()
    {
        $virtualAccount = $this->getNewVirtualAccount();
        $wallet = $this->getJohnsWallet();
        $fetchedVirtualAccount = $this->_api->VirtualAccounts->Get($wallet->Id, $virtualAccount->Id);

        $this->assertNotNull($fetchedVirtualAccount);
        $this->assertEquals($fetchedVirtualAccount->Id, $virtualAccount->Id);
    }

    public function test_VirtualAccount_GetAll()
    {
        $this->getNewVirtualAccount();
        $wallet = $this->getJohnsWallet();

        $virtualAccounts = $this->_api->VirtualAccounts->GetAll($wallet->Id);

        $this->assertNotNull($virtualAccounts);
        $this->assertTrue(is_array($virtualAccounts), 'Expected an array');
        $this->assertEquals(1, sizeof($virtualAccounts));
    }

    public function test_VirtualAccount_Get_Availabilities()
    {
//        TODO
        $this->markTestIncomplete(
            "API issue. To be re-enabled once fixed"
        );
        $virtualAccountAvailabilities = $this->_api->VirtualAccounts->GetAvailabilities();

        $this->assertNotNull($virtualAccountAvailabilities);
        $this->assertTrue(is_array($virtualAccountAvailabilities->Collection), 'Expected an array');
        $this->assertTrue(is_array($virtualAccountAvailabilities->UserOwned), 'Expected an array');
    }

    public function test_VirtualAccount_Deactivate()
    {
        $virtualAccount = $this->getNewVirtualAccount();
        $wallet = $this->getJohnsWallet();
        $deactivatedVirtualAccount = $this->_api->VirtualAccounts->Deactivate($wallet->Id, $virtualAccount->Id);

        $this->assertNotTrue($deactivatedVirtualAccount->Active);
        $this->assertEquals('CLOSED', $deactivatedVirtualAccount->Status);
    }
}
