<?php

namespace MangoPay;

/**
 * Dispute reason types
 */
class DisputeReasonType
{
    public const Duplicate = "DUPLICATE";
    public const Fraud = "FRAUD";
    public const ProductUnacceptable = "PRODUCT_UNACCEPTABLE";
    public const Unknown = "UNKNOWN";
    public const Other = "OTHER";
    public const RefundConversionRate = "REFUND_CONVERSION_RATE";
    public const LateFailureInsufficientFunds = "LATE_FAILURE_INSUFFICIENT_FUNDS";
    public const LateFailureContactUser = "LATE_FAILURE_CONTACT_USER";
    public const LateFailureBankaccountClosed = "LATE_FAILURE_BANKACCOUNT_CLOSED";
    public const LateFailureBankaccountIncompatible = "LATE_FAILURE_BANKACCOUNT_INCOMPATIBLE";
    public const LateFailureBankaccountIncorrect = "LATE_FAILURE_BANKACCOUNT_INCORRECT";
    public const AuthorisationDisputed = "AUTHORISATION_DISPUTED";
    public const TransactionNotRecognized = "TRANSACTION_NOT_RECOGNIZED";
    public const ProductNotProvided = "PRODUCT_NOT_PROVIDED";
    public const CanceledReoccuringTransaction = "CANCELED_REOCCURING_TRANSACTION";
    public const RefundNotProcessed = "REFUND_NOT_PROCESSED";
    public const CounterfeitProduct = "COUNTERFEIT_PRODUCT";
}
