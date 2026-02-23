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
}
