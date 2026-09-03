<?php

namespace MangoPay;

/**
 * Bank Account entity
 */
class BankingAlias extends Libraries\EntityBase
{
    /**
     * Custom data that you can add to this item
     * @var string
     */
    public $Tag;

    /**
     * The User ID who was credited
     * @var string
     */
    public $CreditedUserId;

    /**
     * The ID of a wallet
     * @var string
     */
    public $WalletId;

    /**
     * The type of banking alias (note that only IBAN is available at present)
     * @var BankingAliasType
     */
    public $Type;

    /**
     * The name of the owner of the bank account
     * @var string
     */
    public $OwnerName;

    /**
     * Wether the banking alias is active or not
     * @var bool
     */
    public $Active;

    /**
     * The type of the virtual account
     * Allowed values: `COLLECTION`, `USER_OWNED`
     * @var string|null
     * @see VirtualAccountPurpose
     */
    public $VirtualAccountPurpose;
}
