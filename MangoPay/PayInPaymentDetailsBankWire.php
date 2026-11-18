<?php

namespace MangoPay;

/**
 * Class represents BankWire type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsBankWire extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Declared debited funds
     * @var Money
     */
    public $DeclaredDebitedFunds;

    /**
     * Declared fees
     * @var Money
     */
    public $DeclaredFees;

    /**
     * Bank account details
     * @var BankAccount
     */
    public $BankAccount;

    /**
     * Wire reference
     * @var string
     */
    public $WireReference;

    /**
     * Details of the incoming bank wire transactions.
     * @var PayInTransactionDetailsBankWire[]
     */
    public $TransactionDetails;

    /**
     * The unique identifier of the Virtual Account (or legacy banking alias) targeted by this pay-in.
     * Returned null for a pre-declared (DIRECT) bank wire to a Mangopay account.
     *
     * Note: The same value is returned in both VirtualAccountId and BankingAliasId,
     * but use VirtualAccountId going forward.
     * @var string
     */
    public $VirtualAccountId;

    /**
     * @var string
     */
    public $OperationId;

    /**
     * Information about the account credited by the bank wire.
     *
     * Returned null for a pay-in to a Virtual Account,
     * for which the Virtual Account is the source of truth for its own account details instead.
     * @var CreditedAccount
     */
    public $CreditedAccount;

    /**
     * Information about the account debited to fund the pay-in.
     *
     * For a pre-declared (DIRECT) bank wire to a Mangopay account,
     * this property is returned null while the Status is CREATED, i.e. until the bank wire is received.
     * @var DebitedAccount
     */
    public $DebitedAccount;

    /**
     * Information about an action pending on the pay-in, if any.
     *
     * For example, when CREATED, a pre-declared bank wire shows PAYMENT_REQUIRED as the action.
     * @var PayInPendingAction
     */
    public $PendingAction;

    /**
     * Details of the reconciliation between the declared and received funds for the bank wire.
     *
     * For a pre-declared (DIRECT) bank wire pay-in, returned null while the Status is CREATED,
     * i.e. until the bank wire is received.
     * @var ReconciliationDetails
     */
    public $ReconciliationDetails;

    /**
     * Information about the debited bank account. For a pre-declared (DIRECT) bank wire to a Mangopay account,
     * this property is returned null while the Status is CREATED, i.e. until the bank wire is received.
     * @var DebitedBankAccount
     * @deprecated Replaced by DebitedAccount.
     */
    public $DebitedBankAccount;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'DeclaredDebitedFunds' => '\MangoPay\Money' ,
            'DeclaredFees' => '\MangoPay\Money' ,
            'BankAccount' => '\MangoPay\BankAccount',
            'TransactionDetails' => ['array_single', '\MangoPay\PayInTransactionDetailsBankWire'],
            'CreditedAccount' => '\MangoPay\CreditedAccount',
            'DebitedAccount' => '\MangoPay\DebitedAccount',
            'PendingAction' => '\MangoPay\PayInPendingAction',
            'ReconciliationDetails' => '\MangoPay\ReconciliationDetails',
            'DebitedBankAccount' => '\MangoPay\DebitedBankAccount'
        ];
    }
}
