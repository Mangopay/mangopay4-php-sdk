<?php

namespace MangoPay;

final class ReportStatus
{
    public const Pending = 'PENDING';
    public const Expired = 'EXPIRED';
    public const Failed = 'FAILED';
    public const ReadyForDownload = 'READY_FOR_DOWNLOAD';

    private function __construct()
    {
    }
}
