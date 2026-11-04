<?php

namespace MangoPay;

class CreateCardPreAuthorizedDepositPayIn extends Libraries\EntityBase
{
    /**
     * @var string
     */
    public $AuthorId;

    /**
     * @var string
     */
    public $CreditedWalletId;

    /**
     * @var Money
     */
    public $DebitedFunds;

    /**
     * @var Money
     */
    public $Fees;

    /**
     * @var string
     */
    public $DepositId;

    /**
     * @var string
     */
    public $Tag;

    /**
     * Declarative marketplace information used to comply with
     * Visa Marketplace reporting.
     * @var MarketplaceData
     */
    public $MarketplaceData;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['Fees'] = '\MangoPay\Money';
        $subObjects['MarketplaceData'] = '\MangoPay\MarketplaceData';

        return $subObjects;
    }
}
