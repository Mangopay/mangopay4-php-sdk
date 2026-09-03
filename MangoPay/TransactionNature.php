<?php

namespace MangoPay;

final class TransactionNature
{
    public const Regular = 'REGULAR';
    public const Refund = 'REFUND';
    public const Repudiation = 'REPUDIATION';
    public const Settlement = 'SETTLEMENT';

    private function __construct()
    {
    }
}
