<?php

namespace MangoPay;

class DebitedAccount extends Libraries\Dto
{
    /**
     * The name of the debtor (the registered owner of the debited account).
     * @var string
     */
    public $AccountOwner;

    /**
     * The account identifier of the debtor (e.g. the account number).
     * @var string
     */
    public $BankAccount;

    /**
     * The agent of the debtor (e.g. the BIC or bank code).
     * @var string
     */
    public $BankCode;

    /**
     * The first line of the debtor's address.
     * @var string
     */
    public $AddressLine1;

    /**
     * The second line of the debtor's address.
     * @var string
     */
    public $AddressLine2;

    /**
     * The third line of the debtor's address.
     * @var string
     */
    public $AddressLine3;
}
