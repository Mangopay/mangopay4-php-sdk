<?php

namespace MangoPay;

/**
 * PayIn payment types
 */
class PayInPaymentType
{
    public const BankWire = 'BANK_WIRE';
    public const Card = 'CARD';
    public const DirectDebit = 'DIRECT_DEBIT';
    public const DirectDebitDirect = 'DIRECT_DEBIT_DIRECT';
    public const Preauthorized = 'PREAUTHORIZED';
    public const PayPal = 'PAYPAL';
    public const ApplePay = 'APPLEPAY';
    public const GooglePay = 'GOOGLEPAY';
    public const GooglePayV2 = 'GOOGLE_PAY';
    public const Mbway = 'MBWAY';
    public const Multibanco = 'MULTIBANCO';
    public const Satispay = 'SATISPAY';
    public const Blik = 'BLIK';
    public const Klarna = 'KLARNA';
    public const Ideal = 'IDEAL';
    public const Giropay = 'GIROPAY';
    public const Bancontact = 'BCMC';
    public const Bizum = 'BIZUM';
    public const Swish = 'SWISH';
    public const Twint = 'TWINT';
    public const PayByBank = 'PAY_BY_BANK';
}
