<?php

namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterReports extends FilterTransactions
{
    /**
     * Code to filter.
     *
     * Successful outcome
     * 000000 Success
     *
     * Parameter errors
     * 001999 Generic Operation Error (Operation failed)
     * 001001 Unsufficient wallet balance
     * 001002 The author is not the wallet owner
     * 001011 Transaction amount is higher than maximum permitted amount
     * 001012 Transaction amount is lower than minimum permitted amount
     * 001013 Invalid transaction amount
     * 001014 CreditedFunds must be more than 0 (DebitedFunds can not equal Fees)
     * 001023 Author is not the card owner
     * 001024 Author is not the Mandate owner
     * 001003 Insufficient user account balance
     * 011021 Maximum users reached for this wallet
     * 101108 Transaction refused: the Debited Wallet and the Credited Wallet must be different
     * 001505 The PayIn DebitedFunds can't be higher than the PreAuthorization amount
     *
     * User errors
     * 001030 User has not been redirected
     * 001031 User canceled the payment
     * 001032 User is filling in the payment card details
     * 001033 User has not been redirected then the payment session has expired
     * 001034 User has let the payment session expire without paying
     * 001100 Transaction cancelled by client
     * 101001 The user does not complete transaction
     * 101002 The transaction has been cancelled by the user
     *
     * Refund errors
     * 001499 Refund transaction error
     * 001402 The transaction cannot be refunded
     * 001401 The transaction has already been successfully refunded
     * 001403 The transaction cannot be refunded (max 11 months)
     * 001404 No more refunds can be created against this transaction
     * 005403 The refund cannot exceed initial transaction amount
     * 005404 The refunded fees cannot exceed initial fee amount
     * 001405 The transaction cannot be refunded because the voucher has already been used
     * 005405 Balance of client fee wallet unsufficient
     * 005407 Duplicated operation: you cannot reimburse the same amount more than once for a transaction during the same day
     * 003010 The total DebitedFunds settled cannot exceed the initial transaction DebitedFunds available for settlement
     * 003011 The total Fees settled cannot exceed the initial transaction Fees available for settlement
     * 003012 The repudiation has already been successfully settled
     *
     * Direct debit mandate errors
     * 001801 The bank account has been closed
     * 001802 The bank details supplied were incorrect
     * 001803 Direct debit is not enabled for this bank account
     * 001804 The user has disputed the authorisation of the mandate
     * 001805 The user has cancelled the mandate
     * 001806 The client has cancelled the mandate
     * 001807 User has let the mandate session expire without confirming
     *
     * Direct debit payin errors
     * 001830 There are insufficient funds in the bank account
     * 001831 Contact the user
     * 001832 The payment has been cancelled
     * 001833 The Status of this Mandate does not allow for payments
     *
     * Paypal payin/payout errors
     * 201001 Paypal account balance unsufficient
     * 201002 Paypal related payment instrument declined
     * 201003 Paypal transaction approval has expired
     * 201004 Paypal account's owner has not approved payment
     * 201051 This transaction has been refused by PayPal risk
     * 201052 Paypal account is restricted
     * 201053 Paypal account locked or closed
     *
     * Card input errors
     * 005999 Input datas error
     *
     * 105199 Card input error
     * 105101 Invalid card number
     * 105102 Invalid cardholder name
     * 105103 Invalid PIN code
     * 105104 Invalid PIN format
     * 101410 This card is not active
     *
     * Card registration errors
     * 105299 Token input Error
     * 105202 Card number: invalid format
     * 105203 Expiry date: missing or invalid format
     * 105204 CVV: missing or invalid format
     * 105205 Callback URL: Invalid format
     * 105206 Registration data: Invalid format
     * 001599 Token processing error
     * 101699 CardRegistration error
     *
     * General payin errors
     * 101199 Transaction Refused
     * 101101 Refused by the bank (Do not honor)
     * 101102 Refused by the bank (Amount limit)
     * 101103 Refused by the terminal
     * 101104 Refused by the bank (card limit reached)
     * 101105 The card has expired
     * 101106 The card is inactive
     * 101107 Used card not allowed (ELV)
     *
     * Bank payin blockages
     * 101111 Maximum number of attempts reached
     * 101112 Maximum amount exceeded
     * 101113 Maximum uses exceeded
     * 101115 Debit limit exceeded
     * 101116 Debit transaction frequency exceeded
     * 101117 Exceeding available limit (ELV)
     * 101250 Card holder authentification failed
     *
     * Web Direct debit errors
     * 101201 ELV / Sofort / Giropay...
     * 101202 Bank not supported for Giropay
     * 101203 Account not enabled for Giropay
     * 101204 Card invalid (no entry in authorization database)
     * 101205 Bank code blocked (ELV)
     *
     * 3DS payin errors
     * 101399 Secure mode: 3DSecure authentication is not available
     * 101301 Secure mode: The 3DSecure authentication has failed
     * 101302 Secure mode: The card is not enrolled with 3DSecure
     * 101303 Secure mode: The card is not compatible with 3DSecure
     * 101304 Secure mode: The 3DSecure authentication session has expired
     *
     * KYC problems
     * 002999 Blocked due to a Debited User's KYC limitations (maximum debited or credited amount reached)
     * 002998 Blocked due to the Bank Account Owner's KYC limitations (maximum debited or credited amount reached).
     *
     * Fraud blockages
     * 008999 Suspicion of fraud
     * 008001 Counterfeit Card
     * 008002 Lost Card
     * 008003 Stolen Card
     * 008004 Card bin not authorized
     * 008005 Security violation
     * 008006 Fraud suspected by the bank
     * 008007 Opposition on bank account (Temporary)
     * 008009 Card blocked
     * 008500 Transaction blocked by Fraud Policy
     * 008501 Transaction blocked due to blacklisted country
     * 008502 Transaction blocked due to blacklisted IBAN
     * 008503 Transaction blocked due to blacklisted BIC
     * 008504 Amount of the transaction exceeded the amount permitted
     * 008505 Number of accepted transactions exceeded the velocity limit set
     * 008506 Unauthorized IP address country
     * 008507 Cumulative value of transactions exceeded
     * 008508 Card issuer country not allowed
     * 008509 Number of bank cards allowed is exceeded
     * 008510 Number of clients per card is exceeded
     * 008511 3DSecure authentication failed
     * 008600 Wallet blocked by Fraud policy
     * 008700 User blocked by Fraud policy
     *
     * MANGOPAY payin error
     * 009999 Technical error
     *
     * PSP payin errors
     * 009199 PSP technical error
     * 009101 PSP timeout please try later
     * 109102 Tokenizer internal error
     * 009103 PSP configuration error
     *
     * Bank payin errors
     * 009499 Bank technical error
     *
     * PayOuts
     * 121999 Generic payout errors
     * 121001 The bank wire has been refused
     * 121002 The author is not the wallet owner
     * 121003 Unsufficient wallet balance
     * 121004 Specific case: please contact our Support Team
     * 121004 Other reason
     * 121005 Refused due to the Fraud Policy
     * 121006 The associated bank account is not active
     * 121007 Voucher PayOuts temporarily unavailable - please try again later
     * 121008 Insufficient address info for Payout Author
     * 121009 Insufficient address info for Bank Account
     * 121010 Transaction refused: the author is currently blocked
     * 121011 Transaction refused: the author's wallet is currently blocked
     *
     * Reporting
     * 805001 There was an error validating your report request
     * 809001 There was an error executing your report request
     *
     * @var string
     */
    public $ResultCode;

    /**
     * User ID
     * @var string
     */
    public $AuthorId;

    /**
     * Wallet ID
     * @var string
     */
    public $WalletId;

    /**
     * Minimum debited funds amount
     * @var int
     */
    public $MinDebitedFundsAmount;

    /**
     * Currency for minimal debited funds amount
     * @var string
     */
    public $MinDebitedFundsCurrency;

    /**
     * Maximum debited funds amount
     * @var int
     */
    public $MaxDebitedFundsAmount;

    /**
     * Currency for maximum debited funds amount
     * @var string
     */
    public $MaxDebitedFundsCurrency;

    /**
     * Minimum Fees amount
     * @var int
     */
    public $MinFeesAmount;

    /**
     * Currency for minimal Fees amount
     * @var string
     */
    public $MinFeesCurrency;

    /**
     * Maximum Fees amount
     * @var int
     */
    public $MaxFeesAmount;

    /**
     * Currency for maximum Fees amount
     * @var string
     */
    public $MaxFeesCurrency;

    /**
     * @var int
     */
    public $MinBalanceAmount;
}
