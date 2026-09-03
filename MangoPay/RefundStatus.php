<?php

namespace MangoPay;

final class RefundStatus
{
    public const Created = 'CREATED';
    public const Succeeded = 'SUCCEEDED';
    public const Failed = 'FAILED';

    private function __construct()
    {
    }
}
