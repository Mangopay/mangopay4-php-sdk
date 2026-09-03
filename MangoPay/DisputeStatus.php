<?php

namespace MangoPay;

/**
 * Dispute statuses
 */
class DisputeStatus
{
    public const Created = "CREATED";
    public const PendingClientAction = "PENDING_CLIENT_ACTION";
    public const Submitted = "SUBMITTED";
    public const PendingBankAction = "PENDING_BANK_ACTION";
    public const ReopenedPendingClientAction = "REOPENED_PENDING_CLIENT_ACTION";
    public const Closed = "CLOSED";
}
