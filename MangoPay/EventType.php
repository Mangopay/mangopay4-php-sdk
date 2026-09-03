<?php

namespace MangoPay;

/**
 * Event types
 */
class EventType
{
    public const KycCreated = "KYC_CREATED";
    public const KycSucceeded = "KYC_SUCCEEDED";
    public const KycFailed = "KYC_FAILED";
    public const KycOutdated = "KYC_OUTDATED";
    public const KycValidationAsked  = "KYC_VALIDATION_ASKED";
    public const PayinNormalCreated = "PAYIN_NORMAL_CREATED";
    public const PayinNormalSucceeded = "PAYIN_NORMAL_SUCCEEDED";
    public const PayinNormalFailed = "PAYIN_NORMAL_FAILED";
    public const PayoutNormalCreated = "PAYOUT_NORMAL_CREATED";
    public const PayinNormalProcessingStatusPendingSucceeded = "PAYIN_NORMAL_PROCESSING_STATUS_PENDING_SUCCEEDED";
    public const PayoutNormalSucceeded = "PAYOUT_NORMAL_SUCCEEDED";
    public const PayoutNormalFailed = "PAYOUT_NORMAL_FAILED";
    public const TransferNormalCreated = "TRANSFER_NORMAL_CREATED";
    public const TransferNormalSucceeded = "TRANSFER_NORMAL_SUCCEEDED";
    public const TransferNormalFailed = "TRANSFER_NORMAL_FAILED";
    public const PayinRefundCreated = "PAYIN_REFUND_CREATED";
    public const PayinRefundSucceeded = "PAYIN_REFUND_SUCCEEDED";
    public const PayinRefundFailed = "PAYIN_REFUND_FAILED";
    public const PayoutRefundCreated = "PAYOUT_REFUND_CREATED";
    public const PayoutRefundSucceeded = "PAYOUT_REFUND_SUCCEEDED";
    public const PayoutRefundFailed = "PAYOUT_REFUND_FAILED";
    public const TransferRefundCreated = "TRANSFER_REFUND_CREATED";
    public const TransferRefundSucceeded = "TRANSFER_REFUND_SUCCEEDED";
    public const TransferRefundFailed = "TRANSFER_REFUND_FAILED";
    public const PayinRepudiationCreated = "PAYIN_REPUDIATION_CREATED";
    public const PayinRepudiationSucceeded = "PAYIN_REPUDIATION_SUCCEEDED";
    public const PayinRepudiationFailed = "PAYIN_REPUDIATION_FAILED";
    public const DisputeDocumentCreated = "DISPUTE_DOCUMENT_CREATED";
    public const DisputeDocumentValidationAsked = "DISPUTE_DOCUMENT_VALIDATION_ASKED";
    public const DisputeDocumentSucceeded = "DISPUTE_DOCUMENT_SUCCEEDED";
    public const DisputeDocumentFailed = "DISPUTE_DOCUMENT_FAILED";
    public const DisputeCreated = "DISPUTE_CREATED";
    public const DisputeSubmitted = "DISPUTE_SUBMITTED";
    public const DisputeActionRequired = "DISPUTE_ACTION_REQUIRED";
    public const DisputeFurtherActionRequired = "DISPUTE_FURTHER_ACTION_REQUIRED";
    public const DisputeClosed = "DISPUTE_CLOSED";
    public const DisputeSentToBank = "DISPUTE_SENT_TO_BANK";
    public const TransferSettlementCreated = "TRANSFER_SETTLEMENT_CREATED";
    public const TransferSettlementSucceeded = "TRANSFER_SETTLEMENT_SUCCEEDED";
    public const TransferSettlementFailed = "TRANSFER_SETTLEMENT_FAILED";
    public const MandateCreated = "MANDATE_CREATED";
    //MandatedFailed typo to be deprecated, typo fixed.
    public const MandatedFailed = "MANDATE_FAILED";
    public const MandateFailed = "MANDATE_FAILED";
    public const MandateActivated = "MANDATE_ACTIVATED";
    public const MandateSubmitted = "MANDATE_SUBMITTED";
    public const MandateExpired = "MANDATE_EXPIRED";
    public const PreAuthorizationPaymentWaiting = "PREAUTHORIZATION_PAYMENT_WAITING";
    public const PreAuthorizationPaymentExpired = "PREAUTHORIZATION_PAYMENT_EXPIRED";
    public const PreAuthorizationPaymentCanceled = "PREAUTHORIZATION_PAYMENT_CANCELED";
    public const PreAuthorizationPaymentValidated = "PREAUTHORIZATION_PAYMENT_VALIDATED";
    public const UboDeclarationCreated = "UBO_DECLARATION_CREATED";
    public const UboDeclarationValidationAsked = "UBO_DECLARATION_VALIDATION_ASKED";
    public const UboDeclarationRefused = "UBO_DECLARATION_REFUSED";
    public const UboDeclarationValidated = "UBO_DECLARATION_VALIDATED";
    public const UboDeclarationIncomplete = "UBO_DECLARATION_INCOMPLETE";
    public const UserKycRegular = "USER_KYC_REGULAR";
    public const UserKycLight = "USER_KYC_LIGHT";
    public const UserKycRenewalRequired = "USER_KYC_RENEWAL_REQUIRED";
    public const UserKycRenewed = "USER_KYC_RENEWED";
    public const UserInflowsBlocked = "USER_INFLOWS_BLOCKED";
    public const UserInflowsUnblocked = "USER_INFLOWS_UNBLOCKED";
    public const UserOutflowsBlocked = "USER_OUTFLOWS_BLOCKED";
    public const UserOutflowsUnblocked = "USER_OUTFLOWS_UNBLOCKED";
    public const PreAuthorizationCreated = "PREAUTHORIZATION_CREATED";
    public const PreAuthorizationSucceeded = "PREAUTHORIZATION_SUCCEEDED";
    public const PreAuthorizationFailed = "PREAUTHORIZATION_FAILED";

    public const InstantPayoutSucceeded = "INSTANT_PAYOUT_SUCCEEDED";
    public const InstantPayoutFallbacked = "INSTANT_PAYOUT_FALLBACKED";

    public const DepositPreAuthorizationCreated = "DEPOSIT_PREAUTHORIZATION_CREATED";
    public const DepositPreAuthorizationFailed = "DEPOSIT_PREAUTHORIZATION_FAILED";
    public const DepositPreAuthorizationPaymentWaiting = "DEPOSIT_PREAUTHORIZATION_PAYMENT_WAITING";
    public const DepositPreAuthorizationPaymentExpired = "DEPOSIT_PREAUTHORIZATION_PAYMENT_EXPIRED";
    public const DepositPreAuthorizationPaymentCancelRequested = "DEPOSIT_PREAUTHORIZATION_PAYMENT_CANCEL_REQUESTED";
    public const DepositPreAuthorizationPaymentCanceled = "DEPOSIT_PREAUTHORIZATION_PAYMENT_CANCELED";
    public const DepositPreAuthorizationPaymentValidated = "DEPOSIT_PREAUTHORIZATION_PAYMENT_VALIDATED";
    public const CardValidationCreated = "CARD_VALIDATION_CREATED";
    public const CardValidationFailed = "CARD_VALIDATION_FAILED";
    public const CardValidationSucceeded = "CARD_VALIDATION_SUCCEEDED";
    public const VirtualAccountActive = "VIRTUAL_ACCOUNT_ACTIVE";
    public const VirtualAccountBlocked = "VIRTUAL_ACCOUNT_BLOCKED";
    public const VirtualAccountClosed = "VIRTUAL_ACCOUNT_CLOSED";
    public const VirtualAccountFailed = "VIRTUAL_ACCOUNT_FAILED";

    public const IdentityVerificationValidated = "IDENTITY_VERIFICATION_VALIDATED";
    public const IdentityVerificationFailed = "IDENTITY_VERIFICATION_FAILED";
    public const IdentityVerificationInconclusive = "IDENTITY_VERIFICATION_INCONCLUSIVE";
    public const IdentityVerificationOutdated = "IDENTITY_VERIFICATION_OUTDATED";
    public const IdentityVerificationPending = "IDENTITY_VERIFICATION_PENDING";
    public const IdentityVerificationExpired = "IDENTITY_VERIFICATION_EXPIRED";
    public const IdentityVerificationPendingPscAction = "IDENTITY_VERIFICATION_PENDING_PSC_ACTION";
    public const IdentityVerificationPscPending = "IDENTITY_VERIFICATION_PSC_PENDING";
    public const IdentityVerificationPscValidated = "IDENTITY_VERIFICATION_PSC_VALIDATED";
    public const IdentityVerificationPscRejected = "IDENTITY_VERIFICATION_PSC_REJECTED";
    public const IdentityVerificationPscAbandoned = "IDENTITY_VERIFICATION_PSC_ABANDONED";

    public const RecipientActive = "RECIPIENT_ACTIVE";
    public const RecipientCanceled = "RECIPIENT_CANCELED";
    public const RecipientDeactivated = "RECIPIENT_DEACTIVATED";
    public const UserAccountValidationAsked = "USER_ACCOUNT_VALIDATION_ASKED";
    public const UserAccountActivated = "USER_ACCOUNT_ACTIVATED";
    public const UserAccountClosed = "USER_ACCOUNT_CLOSED";
    public const InstantConversionCreated = "INSTANT_CONVERSION_CREATED";
    public const InstantConversionSucceeded = "INSTANT_CONVERSION_SUCCEEDED";
    public const InstantConversionFailed = "INSTANT_CONVERSION_FAILED";
    public const QuotedConversionCreated = "QUOTED_CONVERSION_CREATED";
    public const QuotedConversionSucceeded = "QUOTED_CONVERSION_SUCCEEDED";
    public const QuotedConversionFailed = "QUOTED_CONVERSION_FAILED";

    public const CountryAuthorizationUpdated = "COUNTRY_AUTHORIZATION_UPDATED";
    public const DepositPreauthorizationPaymentFailed = "DEPOSIT_PREAUTHORIZATION_PAYMENT_FAILED";
    public const DepositPreauthorizationPaymentNoShow = "DEPOSIT_PREAUTHORIZATION_PAYMENT_NO_SHOW";
    public const DepositPreauthorizationPaymentNoShowRequested = "DEPOSIT_PREAUTHORIZATION_PAYMENT_NO_SHOW_REQUESTED";
    public const DepositPreauthorizationPaymentToBeCompleted = "DEPOSIT_PREAUTHORIZATION_PAYMENT_TO_BE_COMPLETED";
    public const RecurringRegistrationAuthNeeded = "RECURRING_REGISTRATION_AUTH_NEEDED";
    public const RecurringRegistrationCreated = "RECURRING_REGISTRATION_CREATED";
    public const RecurringRegistrationEnded = "RECURRING_REGISTRATION_ENDED";
    public const RecurringRegistrationInProgress = "RECURRING_REGISTRATION_IN_PROGRESS";
    public const InstantPayoutFailed = "INSTANT_PAYOUT_FAILED";

    public const ScaEnrollmentSucceeded = "SCA_ENROLLMENT_SUCCEEDED";
    public const ScaEnrollmentFailed = "SCA_ENROLLMENT_FAILED";
    public const ScaEnrollmentExpired = "SCA_ENROLLMENT_EXPIRED";
    public const ScaContactInformationUpdateConsentGiven = "SCA_CONTACT_INFORMATION_UPDATE_CONSENT_GIVEN";
    public const ScaContactInformationUpdateConsentRevoked = "SCA_CONTACT_INFORMATION_UPDATE_CONSENT_REVOKED";
    public const ScaTransferConsentGiven = "SCA_TRANSFER_CONSENT_GIVEN";
    public const ScaTransferConsentRevoked = "SCA_TRANSFER_CONSENT_REVOKED";
    public const ScaRecipientRegistrationConsentGiven = "SCA_RECIPIENT_REGISTRATION_CONSENT_GIVEN";
    public const ScaRecipientRegistrationConsentRevoked = "SCA_RECIPIENT_REGISTRATION_CONSENT_REVOKED";
    public const ScaViewAccountInformationConsentGiven = "SCA_VIEW_ACCOUNT_INFORMATION_CONSENT_GIVEN";
    public const ScaViewAccountInformationConsentRevoked = "SCA_VIEW_ACCOUNT_INFORMATION_CONSENT_REVOKED";
    public const ScaEmailVerified = "SCA_EMAIL_VERIFIED";
    public const ScaPhoneNumberVerified = "SCA_PHONE_NUMBER_VERIFIED";

    public const UserCategoryUpdatedToOwner = "USER_CATEGORY_UPDATED_TO_OWNER";
    public const UserCategoryUpdatedToPayer = "USER_CATEGORY_UPDATED_TO_PAYER";
    public const UserCategoryUpdatedToPlatform = "USER_CATEGORY_UPDATED_TO_PLATFORM";

    public const ReportGenerated = "REPORT_GENERATED";
    public const ReportFailed = "REPORT_FAILED";

    public const IntentAuthorized = "INTENT_AUTHORIZED";
    public const IntentCaptured = "INTENT_CAPTURED";
    public const IntentRefunded = "INTENT_REFUNDED";
    public const IntentRefundReversed = "INTENT_REFUND_REVERSED";
    public const IntentDisputeCreated = "INTENT_DISPUTE_CREATED";
    public const IntentDisputeDefended = "INTENT_DISPUTE_DEFENDED";
    public const IntentDisputeWon = "INTENT_DISPUTE_WON";
    public const IntentDisputeLost = "INTENT_DISPUTE_LOST";
    public const IntentSettledNotPaid = "INTENT_SETTLED_NOT_PAID";
    public const IntentPaid = "INTENT_PAID";

    public const SplitCreated = "SPLIT_CREATED";
    public const SplitPendingFundsReception = "SPLIT_PENDING_FUNDS_RECEPTION";
    public const SplitAvailable = "SPLIT_AVAILABLE";
    public const SplitRejected = "SPLIT_REJECTED";
    public const SplitReversed = "SPLIT_REVERSED";
}
