<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class CreateClientWalletsInstantConversion extends Dto
{
    /**
     * Allowed values: FEES, CREDIT
     *
     * <p>The type of the client wallet to be debited:</p>
     * <p>FEES – Fees Wallet, for fees collected by the platform.</p>
     * <p>CREDIT – Repudiation Wallet, for funds related to dispute management.</p>
     * <p>The amount and currency of the debited funds are defined by the quote.</p>
     * @var string
     */
    public $DebitedWalletType;

    /**
     * The sell funds
     * @var Money
     */
    public $DebitedFunds;

    /**
     * Allowed values: FEES, CREDIT
     *
     * <p>The type of the client wallet to be credited:</p>
     * <p>FEES – Fees Wallet, for fees collected by the platform.</p>
     * <p>CREDIT – Repudiation Wallet, for funds related to dispute management.</p>
     * <p>The amount and currency of the credited funds are defined by the quote.</p>
     * @var string
     */
    public $CreditedWalletType;

    /**
     * The buy funds
     * @var Money
     */
    public $CreditedFunds;

    /**
     * Custom data.
     * @var string
     */
    public $Tag;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['CreditedFunds'] = '\MangoPay\Money';

        return $subObjects;
    }
}
