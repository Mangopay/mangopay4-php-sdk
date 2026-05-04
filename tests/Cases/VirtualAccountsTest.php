<?php

namespace MangoPay\Tests\Cases;

use MangoPay\InternationalAccount;
use MangoPay\InternationalAccountDetails;
use MangoPay\LocalAccount;
use MangoPay\LocalAccountDetails;
use MangoPay\VirtualAccountAddress;
use MangoPay\VirtualAccountCapabilities;

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
        $this->assertInstanceOf(LocalAccountDetails::class, $virtualAccount->LocalAccountDetails);
        $this->assertInstanceOf(InternationalAccountDetails::class, $virtualAccount->InternationalAccountDetails[0]);
        $this->assertInstanceOf(VirtualAccountCapabilities::class, $virtualAccount->Capabilities);
        $this->assertInstanceOf(VirtualAccountAddress::class, $virtualAccount->InternationalAccountDetails[0]->Address);
        $this->assertInstanceOf(InternationalAccount::class, $virtualAccount->InternationalAccountDetails[0]->Account);
        $this->assertInstanceOf(VirtualAccountAddress::class, $virtualAccount->LocalAccountDetails->Address);
        $this->assertInstanceOf(LocalAccount::class, $virtualAccount->LocalAccountDetails->Account);
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
        $virtualAccountAvailabilities = $this->_api->VirtualAccounts->GetAvailabilities();

        $this->assertNotNull($virtualAccountAvailabilities);
        $this->assertTrue(is_array($virtualAccountAvailabilities->Collection), 'Expected an array');
        $this->assertTrue(is_array($virtualAccountAvailabilities->UserOwned), 'Expected an array');
        $this->assertInstanceOf('\MangoPay\VirtualAccountAvailability', $virtualAccountAvailabilities->Collection[0]);
        $this->assertInstanceOf('\MangoPay\VirtualAccountAvailability', $virtualAccountAvailabilities->UserOwned[0]);
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
