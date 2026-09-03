<?php

/**
 * Created by PhpStorm.
 * User: CodegileS1
 * Date: 23.08.2017
 * Time: 18:35
 */

namespace MangoPay;

/**
 * Debited bank account object.
 */
class DebitedBankAccount extends Libraries\EntityBase
{
    /**
     * Name of the bank account's owner.
     * @var string
     */
    public $OwnerName;

    /**
     * The Account Number
     */
    public $AccountNumber;

    /**
     * IBAN
     */
    public $IBAN;

    /**
     * BIC
     */
    public $BIC;

    /**
     * Type
     */
    public $Type;

    /**
     * Country
     */
    public $Country;
}
