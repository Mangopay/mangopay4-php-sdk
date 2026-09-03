<?php

namespace MangoPay;

final class TransactionType
{
    public const PayIn = 'PAYIN';
    public const Transfer = 'TRANSFER';
    public const PayOut = 'PAYOUT';
    public const CardValidation = 'CARD_VALIDATION';
    public const Conversion = 'CONVERSION';

    private function __construct()
    {
    }
}
