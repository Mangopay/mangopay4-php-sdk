<?php

namespace MangoPay;

final class TransactionStatus
{
    public const Created = 'CREATED';
    public const Succeeded = 'SUCCEEDED';
    public const Failed = 'FAILED';

    private function __construct()
    {
    }
}
