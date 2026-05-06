<?php

namespace MangoPay;

class LocalAccount extends Libraries\Dto
{
    /**
     * The account number of the account
     * @var string
     */
    public $AccountNumber;

    /**
     * The sort code of the account.
     * @var string
     */
    public $SortCode;

    /**
     * The international bank account number (IBAN) of the account.
     * @var string
     */
    public $Iban;

    /**
     * The bank identifier code (BIC) of the account.
     * @var string
     */
    public $Bic;

    /**
     * The 9-digit ACH routing number of the account.
     * @var string
     */
    public $AchNumber;

    /**
     * The 9-digit Fedwire (ABA) number of the account.
     * @var string
     */
    public $FedWireNumber;

    /**
     * The account type of the account
     * @var string
     */
    public $AccountType;

    /**
     * The 5-digit branch code or transit number of the account.
     * @var string
     */
    public $BranchCode;

    /**
     * The 3-digit institution number of the account.
     * @var string
     */
    public $InstitutionNumber;

    /**
     * The 4-digit bank code of the account
     * @var string
     */
    public $BankCode;

    /**
     * The 6-digit bank state branch (BSB) code of the account.
     * @var string
     */
    public $BSBCode;

    /**
     * The 5-digit bank clearing number of the account
     * @var string
     */
    public $BCNumber;
}
