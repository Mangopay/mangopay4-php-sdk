<?php

namespace MangoPay;

/**
 * KYC document statuses
 */
class KycDocumentStatus
{
    public const Created = 'CREATED';
    public const ValidationAsked = 'VALIDATION_ASKED';
    public const Validated = 'VALIDATED';
    public const Refused = 'REFUSED';
    public const OutOfDate = 'OUT_OF_DATE';
}
