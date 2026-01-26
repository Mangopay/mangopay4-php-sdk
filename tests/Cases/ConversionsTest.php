<?php

namespace MangoPay\Tests\Cases;

use MangoPay\ConversionQuote;
use MangoPay\CreateClientWalletsInstantConversion;
use MangoPay\CreateClientWalletsQuotedConversion;
use MangoPay\CreateInstantConversion;
use MangoPay\CreateQuotedConversion;
use MangoPay\CustomFees;
use MangoPay\Money;
use MangoPay\TransactionType;
use MangoPay\UserMargin;
use function PHPUnit\Framework\assertNotNull;

class ConversionsTest extends Base
{
    public function test_getConversionRate()
    {
        $response = $this->_api->Conversions->GetConversionRate('EUR', 'GBP');

        $this->assertNotNull($response);
        $this->assertNotNull($response->ClientRate);
        $this->assertNotNull($response->MarketRate);
    }

    public function test_createInstantConversion()
    {
        $response = $this->createInstantConversion();

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertNotNull($response->Fees);
        $this->assertSame('SUCCEEDED', $response->Status);
        $this->assertSame(TransactionType::Conversion, $response->Type);
        $this->assertNotNull($response->RequestedFees);
        $this->assertSame("FIXED", $response->RequestedFees->Type);
        $this->assertNotNull($response->MarginsResponse->Mangopay);
        $this->assertNull($response->MarginsResponse->User);
    }

    public function test_getInstantConversion()
    {
        $instantConversion = $this->createInstantConversion();
        $returnedInstantConversion = $this->_api->Conversions->GetConversion($instantConversion->Id);

        $this->assertNotNull($returnedInstantConversion);
        $this->assertNotNull($returnedInstantConversion->DebitedFunds->Amount);
        $this->assertNotNull($returnedInstantConversion->CreditedFunds->Amount);
        $this->assertNotNull($returnedInstantConversion->Fees);
        $this->assertSame('SUCCEEDED', $returnedInstantConversion->Status);
        $this->assertSame(TransactionType::Conversion, $returnedInstantConversion->Type);
    }

    public function test_createConversionQuote()
    {
        $fees = new CustomFees();
        $fees->Currency = 'EUR';
        $fees->Amount = 100;
        $fees->Type = "PERCENTAGE";
        $response = $this->createConversionQuote($fees);

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertNotNull($response->ConversionRateResponse->ClientRate);
        $this->assertSame('ACTIVE', $response->Status);
        $this->assertSame("PERCENTAGE", $response->RequestedFees->Type);
        $this->assertNotNull($response->MarginsResponse->Mangopay);
        $this->assertNotNull($response->MarginsResponse->User);
    }

    public function test_getConversionQuote()
    {
        $quote = $this->createConversionQuote();
        $response = $this->_api->Conversions->GetConversionQuote($quote->Id);

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertNotNull($response->ConversionRateResponse->ClientRate);
        $this->assertSame('ACTIVE', $response->Status);
    }

    public function test_createQuotedConversion()
    {
        $response = $this->createQuotedConversion();
        assertNotNull($response);
        assertNotNull($response->QuoteId);
    }

    public function test_createClientWalletsQuotedConversion()
    {
        $response = $this->createClientWalletsQuotedConversion();
        assertNotNull($response);
        assertNotNull($response->QuoteId);
    }

    public function test_getQuotedConversion()
    {
        $createdQuotedConversion = $this->createQuotedConversion();
        $response = $this->_api->Conversions->GetConversion($createdQuotedConversion->Id);
        assertNotNull($response);
        assertNotNull($response->QuoteId);
    }

    public function test_createClientWalletsInstantConversion()
    {
        $response = $this->createClientWalletsInstantConversion();

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertSame('SUCCEEDED', $response->Status);
        $this->assertSame(TransactionType::Conversion, $response->Type);
    }

    private function createQuotedConversion()
    {
        $john = $this->getJohn();
        $creditedWallet = new \MangoPay\Wallet();
        $creditedWallet->Owners = [$john->Id];
        $creditedWallet->Currency = 'GBP';
        $creditedWallet->Description = 'WALLET IN EUR WITH MONEY';

        $creditedWallet = $this->_api->Wallets->Create($creditedWallet);

        $debitedWallet = $this->getJohnsWalletWithMoney();

        $quote = $this->createConversionQuote();

        $quotedConversion = new CreateQuotedConversion();
        $quotedConversion->QuoteId = $quote->Id;
        $quotedConversion->AuthorId = $debitedWallet->Owners[0];
        $quotedConversion->CreditedWalletId = $creditedWallet->Id;
        $quotedConversion->DebitedWalletId = $debitedWallet->Id;

        return $this->_api->Conversions->CreateQuotedConversion($quotedConversion);
    }

    private function createClientWalletsQuotedConversion()
    {
        $quote = $this->createConversionQuote();

        $quotedConversion = new CreateClientWalletsQuotedConversion();
        $quotedConversion->QuoteId = $quote->Id;
        $quotedConversion->DebitedWalletType = 'FEES';
        $quotedConversion->CreditedWalletType = 'CREDIT';
        $quotedConversion->Tag = 'Created via the PHP SDK';

        return $this->_api->Conversions->CreateClientWalletsQuotedConversion($quotedConversion);
    }

    private function createInstantConversion()
    {
        $john = $this->getJohn();
        $creditedWallet = new \MangoPay\Wallet();
        $creditedWallet->Owners = [$john->Id];
        $creditedWallet->Currency = 'GBP';
        $creditedWallet->Description = 'WALLET IN EUR WITH MONEY';

        $creditedWallet = $this->_api->Wallets->Create($creditedWallet);

        $debitedWallet = $this->getJohnsWalletWithMoney();

        $instantConversion = new CreateInstantConversion();
        $instantConversion->AuthorId = $debitedWallet->Owners[0];
        $instantConversion->CreditedWalletId = $creditedWallet->Id;
        $instantConversion->DebitedWalletId = $debitedWallet->Id;

        $creditedFunds = new Money();
        $creditedFunds->Currency = 'GBP';
        $instantConversion->CreditedFunds = $creditedFunds;

        $debitedFunds = new Money();
        $debitedFunds->Currency = 'EUR';
        $debitedFunds->Amount = 79;
        $instantConversion->DebitedFunds = $debitedFunds;

        $fees = new CustomFees();
        $fees->Currency = 'EUR';
        $fees->Amount = 9;
        $instantConversion->Fees = $fees;

        $instantConversion->Tag = "create instant conversion";

        return $this->_api->Conversions->CreateInstantConversion($instantConversion);
    }

    private function createClientWalletsInstantConversion()
    {
        $creditedFunds = new Money();
        $creditedFunds->Currency = 'USD';

        $debitedFunds = new Money();
        $debitedFunds->Currency = 'EUR';
        $debitedFunds->Amount = 100;

        $instantConversion = new CreateClientWalletsInstantConversion();
        $instantConversion->DebitedWalletType = 'FEES';
        $instantConversion->DebitedFunds = $debitedFunds;
        $instantConversion->CreditedWalletType = 'FEES';
        $instantConversion->CreditedFunds = $creditedFunds;

        $instantConversion->Tag = "Client wallets instant conversion via the PHP SDK";

        return $this->_api->Conversions->CreateClientWalletsInstantConversion($instantConversion);
    }

    private function createConversionQuote($fees = null)
    {
        $quote = new ConversionQuote();
        $creditedFunds = new Money();
        $creditedFunds->Currency = 'GBP';
        $quote->CreditedFunds = $creditedFunds;

        $debitedFunds = new Money();
        $debitedFunds->Currency = 'EUR';
        $debitedFunds->Amount = 50;
        $quote->DebitedFunds = $debitedFunds;

        $quote->Duration = 300;
        $quote->Tag = "Created using the Mangopay PHP SDK";
        $quote->Fees = $fees;

        $userMargin = new UserMargin();
        $userMargin->Type = "PERCENTAGE";
        $userMargin->Value = 0.1;
        $quote->UserMargin = $userMargin;

        return $this->_api->Conversions->CreateConversionQuote($quote);
    }
}
