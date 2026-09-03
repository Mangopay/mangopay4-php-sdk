<?php

namespace MangoPay;

/**
 * Dispute document statuses
 */
class DisputeDocumentStatus
{
    public const Created = "CREATED";
    public const ValidationAsked = "VALIDATION_ASKED";
    public const Validated = "VALIDATED";
    public const Refused = "REFUSED";
}
