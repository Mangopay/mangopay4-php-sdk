<?php

namespace MangoPay;

/**
 * Kyc Refused Reason Type
 */
class KycDocumentRefusedReasonType
{
    public const DocumentUnreadable = 'DOCUMENT_UNREADABLE';
    public const DocumentNotAccepted = 'DOCUMENT_NOT_ACCEPTED';
    public const DocumentHasExpired = 'DOCUMENT_HAS_EXPIRED';
    public const DocumentIncomplete = 'DOCUMENT_INCOMPLETE';
    public const DocumentMissing = 'DOCUMENT_MISSING';
    public const DocumentDoesNotMatchUserData = 'DOCUMENT_DO_NOT_MATCH_USER_DATA';
    public const DocumentDoesNotMatchAccountData = 'DOCUMENT_DO_NOT_MATCH_ACCOUNT_DATA';
    public const SpecificCase = 'SPECIFIC_CASE';
    public const DocumentFalsified = 'DOCUMENT_FALSIFIED';
    public const UnderagePerson = 'UNDERAGE_PERSON';
    public const TriggerPEPS = 'TRIGGER_PEPS';
    public const TriggerSanactionLists = 'TRIGGER_SANACTION_LISTS';
    public const TriggerInterpol = 'TRIGGER_INTERPOL';
}
