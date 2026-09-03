<?php

namespace MangoPay;

final class DepositStatus
{
    public const Created = 'CREATED';
    public const Succeeded = 'SUCCEEDED';
    public const Failed = 'FAILED';

    private function __construct()
    {
    }
}
