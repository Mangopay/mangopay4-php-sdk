<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for instant conversions
 */
class ApiConversions extends Libraries\ApiBase
{
    /**
     * This endpoint allows the platform to get a real
     * time indicative market rate of a specific currency pair.
     * The rate returned is given in real time.
     * @param string $debitedCurrency The sell currency – the currency of the wallet to be debited
     * @param string $creditedCurrency The buy currency – the currency of the wallet to be credited.
     * @return \MangoPay\ConversionRate object returned from API
     */
    public function GetConversionRate($debitedCurrency, $creditedCurrency)
    {
        return $this->GetObject('get_conversion_rate', '\MangoPay\ConversionRate', $debitedCurrency, $creditedCurrency);
    }

    /**
     * This endpoint allows the platform to move funds between two
     * wallets of different currencies instantaneously.
     * @param CreateInstantConversion $instantConversion
     * @return \MangoPay\Conversion object returned from API
     */
    public function CreateInstantConversion($instantConversion, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'create_instant_conversion',
            $instantConversion,
            '\MangoPay\Conversion',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * This call triggers an immediate conversion at the market rate,
     * of the debited funds to the credited wallet at the market rate.
     * A quote is not required for an instant conversion.
     *
     * @param CreateClientWalletsInstantConversion $instantConversion
     * @return \MangoPay\Conversion object returned from API
     */
    public function CreateClientWalletsInstantConversion($instantConversion, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'create_client_wallets_instant_conversion',
            $instantConversion,
            '\MangoPay\Conversion',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * This call triggers a conversion, at the rate guaranteed by its quote, of the debited funds to the credited wallet.
     *
     * @param CreateQuotedConversion $quotedConversion
     * @return Conversion
     */
    public function CreateQuotedConversion($quotedConversion, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'create_quoted_conversion',
            $quotedConversion,
            '\MangoPay\Conversion',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * This call triggers a conversion at the rate defined in its quote.
     * The debited funds (buy currency), credited funds (sell currency) and currencies are defined in the quote.
     * The Client Wallets to debit and credit are defined in the conversion.
     *
     * Each quoted conversion requires a dedicated Quote object, linked in the QuoteId.*
     *
     * @param CreateClientWalletsQuotedConversion $quotedConversion
     * @return Conversion
     */
    public function CreateClientWalletsQuotedConversion($quotedConversion, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'create_client_wallets_quoted_conversion',
            $quotedConversion,
            '\MangoPay\Conversion',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * This endpoint allows the platform to get
     * the details of a conversion which has been carried out.
     * @param string $id The unique identifier of the conversion.
     * @return \MangoPay\Conversion object returned from API
     */
    public function GetConversion($id)
    {
        return $this->GetObject('get_conversion', '\MangoPay\Conversion', $id);
    }

    /**
     * This call guarantees a conversion rate to let you Create a Quoted Conversion.
     * @param ConversionQuote $quote
     * @return ConversionQuote
     */
    public function CreateConversionQuote($quote, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'create_conversion_quote',
            $quote,
            '\MangoPay\ConversionQuote',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * This endpoint allows the platform to get the details of a quote
     * @param string $quoteId
     * @return ConversionQuote
     */
    public function GetConversionQuote($quoteId)
    {
        return $this->GetObject('get_conversion_quote', '\MangoPay\ConversionQuote', $quoteId);
    }
}
