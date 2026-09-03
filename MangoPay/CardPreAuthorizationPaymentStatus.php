<?php

namespace MangoPay;

/**
 * Pre-authorization payment statuses
 */
class CardPreAuthorizationPaymentStatus
{
    public const Canceled = 'CANCELED';
    public const Expired = 'EXPIRED';
    public const Validated = 'VALIDATED';
    public const Waiting = 'WAITING';
    public const CancelRequested = 'CANCEL_REQUESTED';
    public const ToBeCompleted = 'TO_BE_COMPLETED';
    public const NoShowRequested = 'NO_SHOW_REQUESTED';
    public const NoShow = 'NO_SHOW';
    public const Failed = 'FAILED';
}
