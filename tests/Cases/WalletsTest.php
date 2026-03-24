<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for wallets
 */
class WalletsTest extends Base
{
    public function test_Wallets_Create()
    {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();

        $this->assertNotNull($wallet->Id);
        $this->assertTrue(in_array($john->Id, $wallet->Owners));
    }

    public function test_Wallets_Get()
    {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();

        $getWallet = $this->_api->Wallets->Get($wallet->Id);

        $this->assertSame($wallet->Id, $getWallet->Id);
        $this->assertTrue(in_array($john->Id, $getWallet->Owners));
    }

    public function test_Wallets_Get_Sca()
    {
        $user = $this->getJohnScaOwnerDto(false);
        $user = $this->_api->Users->Create($user);
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$user->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR';
        $wallet = $this->_api->Wallets->Create($wallet);

        try {
            $this->_api->Wallets->Get($wallet->Id, "USER_PRESENT");
        } catch (\Exception $exception) {
            $this->assertSame(401, $exception->getCode());
            $this->assertNotNull($exception->GetErrorDetails()->Errors['Sca']);
            $this->assertNotNull($exception->GetErrorDetails()->Data['RedirectUrl']);
        }
    }

    public function test_Wallets_Save()
    {
        $wallet = $this->getJohnsWallet();
        $wallet->Description = 'New description to test';

        $saveWallet = $this->_api->Wallets->Update($wallet);

        $this->assertSame($wallet->Id, $saveWallet->Id);
        $this->assertSame('New description to test', $saveWallet->Description);
    }

    public function test_Wallets_Transactions()
    {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();
        self::$JohnsPayInCardWeb = null;
        $payIn = $this->getJohnsPayInCardWeb();
        sleep(5);

        $pagination = new \MangoPay\Pagination(1, 1);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';
        $transactions = $this->_api->Wallets->GetTransactions($wallet->Id, $pagination, $filter);

        $this->assertEquals(1, count($transactions));
        $this->assertInstanceOf('\MangoPay\Transaction', $transactions[0]);
        $this->assertEquals($john->Id, $transactions[0]->AuthorId);

        /**
         * TODO - investigate why this assertion fails when running all the tests. When running it individually, it
         * doesn't fail.
         * https://travis-ci.org/Mangopay/mangopay2-php-sdk/builds/208607353#L349
         */
//        $this->assertIdenticalInputProps($transactions[0], $payIn);
    }

    public function test_Wallets_Transactions_Sca()
    {
        $user = $this->buildJohn(false);
        $user = $this->_api->Users->Create($user);
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$user->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR';
        $wallet = $this->_api->Wallets->Create($wallet);

        $pagination = new \MangoPay\Pagination(1, 1);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';
        $filter->ScaContext = "USER_PRESENT";

        try {
            $this->_api->Wallets->GetTransactions($wallet->Id, $pagination, $filter);
        } catch (\Exception $exception) {
            $this->assertSame(401, $exception->getCode());
            $this->assertNotNull($exception->GetErrorDetails()->Errors['Sca']);
            $this->assertNotNull($exception->GetErrorDetails()->Data['RedirectUrl']);
        }
    }

    public function test_Wallets_Transactions_Filter()
    {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();
        self::$JohnsPayInCardWeb = null;
        $payIn = $this->getJohnsPayInCardWeb();

        $pagination = new \MangoPay\Pagination(1, 1);
        $filter = new \MangoPay\FilterTransactions();
        $filter->BeforeDate = time();
        $filter->AfterDate = strtotime("-1 day");
        sleep(5);
        $transactions = $this->_api->Wallets->GetTransactions($wallet->Id, $pagination, $filter);

        $this->assertEquals(1, count($transactions));
        $this->assertInstanceOf('\MangoPay\Transaction', $transactions[0]);
        $this->assertEquals($john->Id, $transactions[0]->AuthorId);
    }


    public function test_Wallets_Transactions_SortByCreationDate()
    {
        $wallet = $this->getJohnsWallet();
        // create 2 pay-in objects
        self::$JohnsPayInCardWeb = null;
        $this->getJohnsPayInCardWeb();
        self::$JohnsPayInCardWeb = null;
        $this->getJohnsPayInCardWeb();
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);
        $pagination = new \MangoPay\Pagination(1, 20);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';

        $transactions = $this->_api->Wallets->GetTransactions($wallet->Id, $pagination, $filter, $sorting);

        $this->assertTrue($transactions[0]->CreationDate >= $transactions[1]->CreationDate);
    }
}
