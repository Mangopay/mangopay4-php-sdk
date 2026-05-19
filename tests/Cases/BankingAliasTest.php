<?php

namespace MangoPay\Tests\Cases;

use MangoPay\BankingAliasType;

/**
 * Tests basic methods for Banking Aliases
 */
class BankingAliasTest extends Base
{
    public function test_BankingAlias_Create()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();

        $this->assertNotNull($bankingAliasIBAN->Id);
        $this->assertNotNull($bankingAliasIBAN->VirtualAccountPurpose);
    }

    public function test_BankingAliasGB_Create()
    {
        $bankingAliasGB = $this->getJohnsBankingAliasGB();

        $this->assertNotNull($bankingAliasGB->Id);
        $this->assertTrue($bankingAliasGB->Type==BankingAliasType::GB);
    }

    public function test_BankingAlias_Get()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();

        $getBankingAliasIBAN = $this->_api->BankingAliases->Get($bankingAliasIBAN->Id);

        $this->assertSame($bankingAliasIBAN->Id, $getBankingAliasIBAN->Id);
    }

    public function test_BankingAlias_Update()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();
        $bankingAliasIBAN->Active = false;

        $saveBankingAliasIBAN = $this->_api->BankingAliases->Update($bankingAliasIBAN);

        $this->assertSame($bankingAliasIBAN->Id, $saveBankingAliasIBAN->Id);
        $this->assertSame(false, $saveBankingAliasIBAN->Active);
    }

    public function test_BankingAlias_All()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();
        $pagination = new \MangoPay\Pagination(1, 1);

        $list = $this->_api->BankingAliases->GetAll($bankingAliasIBAN->WalletId, $pagination);

        $this->assertInstanceOf('MangoPay\BankingAliasIBAN', $list[0]);
        $this->assertSame($bankingAliasIBAN->Id, $list[0]->Id);
        $this->assertSame(1, $pagination->Page);
        $this->assertSame(1, $pagination->ItemsPerPage);

        if ($list[0]->LocalAccountDetails != null) {
            $this->assertInstanceOf('\MangoPay\LocalAccountDetailsBankingAlias', $list[0]->LocalAccountDetails);
        }
    }
}
