<?php

namespace MangoPay;

/**
 * Event types
 */
class EventType
{
    const KycCreated = "KYC_CREATED";
    const KycSucceeded = "KYC_SUCCEEDED";
    const KycFailed = "KYC_FAILED";
    const KycOutdated = "KYC_OUTDATED";
    const KycValidationAsked  = "KYC_VALIDATION_ASKED";
    const PayinNormalCreated = "PAYIN_NORMAL_CREATED";
    const PayinNormalSucceeded = "PAYIN_NORMAL_SUCCEEDED";
    const PayinNormalFailed = "PAYIN_NORMAL_FAILED";
    const PayoutNormalCreated = "PAYOUT_NORMAL_CREATED";
    const PayinNormalProcessingStatusPendingSucceeded = "PAYIN_NORMAL_PROCESSING_STATUS_PENDING_SUCCEEDED";
    const PayoutNormalSucceeded = "PAYOUT_NORMAL_SUCCEEDED";
    const PayoutNormalFailed = "PAYOUT_NORMAL_FAILED";
    const TransferNormalCreated = "TRANSFER_NORMAL_CREATED";
    const TransferNormalSucceeded = "TRANSFER_NORMAL_SUCCEEDED";
    const TransferNormalFailed = "TRANSFER_NORMAL_FAILED";
    const PayinRefundCreated = "PAYIN_REFUND_CREATED";
    const PayinRefundSucceeded = "PAYIN_REFUND_SUCCEEDED";
    const PayinRefundFailed = "PAYIN_REFUND_FAILED";
    const PayoutRefundCreated = "PAYOUT_REFUND_CREATED";
    const PayoutRefundSucceeded = "PAYOUT_REFUND_SUCCEEDED";
    const PayoutRefundFailed = "PAYOUT_REFUND_FAILED";
    const TransferRefundCreated = "TRANSFER_REFUND_CREATED";
    const TransferRefundSucceeded = "TRANSFER_REFUND_SUCCEEDED";
    const TransferRefundFailed = "TRANSFER_REFUND_FAILED";
    const PayinRepudiationCreated = "PAYIN_REPUDIATION_CREATED";
    const PayinRepudiationSucceeded = "PAYIN_REPUDIATION_SUCCEEDED";
    const PayinRepudiationFailed = "PAYIN_REPUDIATION_FAILED";
    const DisputeDocumentCreated = "DISPUTE_DOCUMENT_CREATED";
    const DisputeDocumentValidationAsked = "DISPUTE_DOCUMENT_VALIDATION_ASKED";
    const DisputeDocumentSucceeded = "DISPUTE_DOCUMENT_SUCCEEDED";
    const DisputeDocumentFailed = "DISPUTE_DOCUMENT_FAILED";
    const DisputeCreated = "DISPUTE_CREATED";
    const DisputeSubmitted = "DISPUTE_SUBMITTED";
    const DisputeActionRequired = "DISPUTE_ACTION_REQUIRED";
    const DisputeFurtherActionRequired = "DISPUTE_FURTHER_ACTION_REQUIRED";
    const DisputeClosed = "DISPUTE_CLOSED";
    const DisputeSentToBank = "DISPUTE_SENT_TO_BANK";
    const TransferSettlementCreated = "TRANSFER_SETTLEMENT_CREATED";
    const TransferSettlementSucceeded = "TRANSFER_SETTLEMENT_SUCCEEDED";
    const TransferSettlementFailed = "TRANSFER_SETTLEMENT_FAILED";
    const MandateCreated = "MANDATE_CREATED";
    //MandatedFailed typo to be deprecated, typo fixed.
    const MandatedFailed = "MANDATE_FAILED";
    const MandateFailed = "MANDATE_FAILED";
    const MandateActivated = "MANDATE_ACTIVATED";
    const MandateSubmitted = "MANDATE_SUBMITTED";
    const MandateExpired = "MANDATE_EXPIRED";
    const PreAuthorizationPaymentWaiting = "PREAUTHORIZATION_PAYMENT_WAITING";
    const PreAuthorizationPaymentExpired = "PREAUTHORIZATION_PAYMENT_EXPIRED";
    const PreAuthorizationPaymentCanceled = "PREAUTHORIZATION_PAYMENT_CANCELED";
    const PreAuthorizationPaymentValidated = "PREAUTHORIZATION_PAYMENT_VALIDATED";
    const UboDeclarationCreated = "UBO_DECLARATION_CREATED";
    const UboDeclarationValidationAsked = "UBO_DECLARATION_VALIDATION_ASKED";
    const UboDeclarationRefused = "UBO_DECLARATION_REFUSED";
    const UboDeclarationValidated = "UBO_DECLARATION_VALIDATED";
    const UboDeclarationIncomplete = "UBO_DECLARATION_INCOMPLETE";
    const UserKycRegular = "USER_KYC_REGULAR";
    const UserKycLight = "USER_KYC_LIGHT";
    const UserKycRenewalRequired = "USER_KYC_RENEWAL_REQUIRED";
    const UserKycRenewed = "USER_KYC_RENEWED";
    const UserInflowsBlocked = "USER_INFLOWS_BLOCKED";
    const UserInflowsUnblocked = "USER_INFLOWS_UNBLOCKED";
    const UserOutflowsBlocked = "USER_OUTFLOWS_BLOCKED";
    const UserOutflowsUnblocked = "USER_OUTFLOWS_UNBLOCKED";
    const PreAuthorizationCreated = "PREAUTHORIZATION_CREATED";
    const PreAuthorizationSucceeded = "PREAUTHORIZATION_SUCCEEDED";
    const PreAuthorizationFailed = "PREAUTHORIZATION_FAILED";

    const InstantPayoutSucceeded = "INSTANT_PAYOUT_SUCCEEDED";
    const InstantPayoutFallbacked = "INSTANT_PAYOUT_FALLBACKED";

    const DepositPreAuthorizationCreated = "DEPOSIT_PREAUTHORIZATION_CREATED";
    const DepositPreAuthorizationFailed = "DEPOSIT_PREAUTHORIZATION_FAILED";
    const DepositPreAuthorizationPaymentWaiting = "DEPOSIT_PREAUTHORIZATION_PAYMENT_WAITING";
    const DepositPreAuthorizationPaymentExpired = "DEPOSIT_PREAUTHORIZATION_PAYMENT_EXPIRED";
    const DepositPreAuthorizationPaymentCancelRequested = "DEPOSIT_PREAUTHORIZATION_PAYMENT_CANCEL_REQUESTED";
    const DepositPreAuthorizationPaymentCanceled = "DEPOSIT_PREAUTHORIZATION_PAYMENT_CANCELED";
    const DepositPreAuthorizationPaymentValidated = "DEPOSIT_PREAUTHORIZATION_PAYMENT_VALIDATED";
    const CardValidationCreated = "CARD_VALIDATION_CREATED";
    const CardValidationFailed= "CARD_VALIDATION_FAILED";
    const CardValidationSucceeded = "CARD_VALIDATION_SUCCEEDED";
    const VirtualAccountActive = "VIRTUAL_ACCOUNT_ACTIVE";
    const VirtualAccountBlocked = "VIRTUAL_ACCOUNT_BLOCKED";
    const VirtualAccountClosed = "VIRTUAL_ACCOUNT_CLOSED";
    const VirtualAccountFailed = "VIRTUAL_ACCOUNT_FAILED";

    const IdentityVerificationValidated = "IDENTITY_VERIFICATION_VALIDATED";
    const IdentityVerificationFailed = "IDENTITY_VERIFICATION_FAILED";
    const IdentityVerificationInconclusive = "IDENTITY_VERIFICATION_INCONCLUSIVE";
    const IdentityVerificationOutdated = "IDENTITY_VERIFICATION_OUTDATED";
    const IdentityVerificationPending = "IDENTITY_VERIFICATION_PENDING";

    const RecipientActive = "RECIPIENT_ACTIVE";
    const RecipientCanceled = "RECIPIENT_CANCELED";
    const RecipientDeactivated = "RECIPIENT_DEACTIVATED";
    const UserAccountValidationAsked = "USER_ACCOUNT_VALIDATION_ASKED";
    const UserAccountActivated = "USER_ACCOUNT_ACTIVATED";
    const UserAccountClosed = "USER_ACCOUNT_CLOSED";
    const InstantConversionCreated = "INSTANT_CONVERSION_CREATED";
    const InstantConversionSucceeded = "INSTANT_CONVERSION_SUCCEEDED";
    const InstantConversionFailed = "INSTANT_CONVERSION_FAILED";
    const QuotedConversionCreated = "QUOTED_CONVERSION_CREATED";
    const QuotedConversionSucceeded = "QUOTED_CONVERSION_SUCCEEDED";
    const QuotedConversionFailed = "QUOTED_CONVERSION_FAILED";

    const CountryAuthorizationUpdated = "COUNTRY_AUTHORIZATION_UPDATED";
    const DepositPreauthorizationPaymentFailed = "DEPOSIT_PREAUTHORIZATION_PAYMENT_FAILED";
    const DepositPreauthorizationPaymentNoShow = "DEPOSIT_PREAUTHORIZATION_PAYMENT_NO_SHOW";
    const DepositPreauthorizationPaymentNoShowRequested = "DEPOSIT_PREAUTHORIZATION_PAYMENT_NO_SHOW_REQUESTED";
    const DepositPreauthorizationPaymentToBeCompleted = "DEPOSIT_PREAUTHORIZATION_PAYMENT_TO_BE_COMPLETED";
    const RecurringRegistrationAuthNeeded = "RECURRING_REGISTRATION_AUTH_NEEDED";
    const RecurringRegistrationCreated = "RECURRING_REGISTRATION_CREATED";
    const RecurringRegistrationEnded = "RECURRING_REGISTRATION_ENDED";
    const RecurringRegistrationInProgress = "RECURRING_REGISTRATION_IN_PROGRESS";
    const InstantPayoutFailed = "INSTANT_PAYOUT_FAILED";

    const ScaEnrollmentSucceeded = "SCA_ENROLLMENT_SUCCEEDED";
    const ScaEnrollmentFailed = "SCA_ENROLLMENT_FAILED";
    const ScaEnrollmentExpired = "SCA_ENROLLMENT_EXPIRED";
    const ScaContactInformationUpdateConsentGiven = "SCA_CONTACT_INFORMATION_UPDATE_CONSENT_GIVEN";
    const ScaContactInformationUpdateConsentRevoked = "SCA_CONTACT_INFORMATION_UPDATE_CONSENT_REVOKED";
    const ScaTransferConsentGiven = "SCA_TRANSFER_CONSENT_GIVEN";
    const ScaTransferConsentRevoked = "SCA_TRANSFER_CONSENT_REVOKED";
    const ScaRecipientRegistrationConsentGiven = "SCA_RECIPIENT_REGISTRATION_CONSENT_GIVEN";
    const ScaRecipientRegistrationConsentRevoked = "SCA_RECIPIENT_REGISTRATION_CONSENT_REVOKED";
    const ScaViewAccountInformationConsentGiven = "SCA_VIEW_ACCOUNT_INFORMATION_CONSENT_GIVEN";
    const ScaViewAccountInformationConsentRevoked = "SCA_VIEW_ACCOUNT_INFORMATION_CONSENT_REVOKED";
    const ScaEmailVerified = "SCA_EMAIL_VERIFIED";
    const ScaPhoneNumberVerified = "SCA_PHONE_NUMBER_VERIFIED";

    const UserCategoryUpdatedToOwner = "USER_CATEGORY_UPDATED_TO_OWNER";
    const UserCategoryUpdatedToPayer = "USER_CATEGORY_UPDATED_TO_PAYER";
    const UserCategoryUpdatedToPlatform = "USER_CATEGORY_UPDATED_TO_PLATFORM";

    const ReportGenerated = "REPORT_GENERATED";
    const ReportFailed = "REPORT_FAILED";

    const IntentAuthorized = "INTENT_AUTHORIZED";
    const IntentCaptured = "INTENT_CAPTURED";
    const IntentRefunded = "INTENT_REFUNDED";
    const IntentRefundReversed = "INTENT_REFUND_REVERSED";
    const IntentDisputeCreated = "INTENT_DISPUTE_CREATED";
    const IntentDisputeDefended = "INTENT_DISPUTE_DEFENDED";
    const IntentDisputeWon = "INTENT_DISPUTE_WON";
    const IntentDisputeLost = "INTENT_DISPUTE_LOST";
    const IntentSettledNotPaid = "INTENT_SETTLED_NOT_PAID";
    const IntentPaid = "INTENT_PAID";

    const SplitCreated = "SPLIT_CREATED";
    const SplitPendingFundsReception = "SPLIT_PENDING_FUNDS_RECEPTION";
    const SplitAvailable = "SPLIT_AVAILABLE";
    const SplitRejected = "SPLIT_REJECTED";
    const SplitReversed = "SPLIT_REVERSED";
}
