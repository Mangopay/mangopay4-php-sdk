<?php

namespace MangoPay;

/**
 * Class represents declarative marketplace information used to comply with
 * Visa Marketplace reporting. During onboarding, clients are advised whether
 * they are required to provide this data.
 */
class MarketplaceData extends Libraries\Dto
{
    /**
     * Indicates whether the Seller to which the pay-in will be transferred is
     * foreign. Foreign is where the Seller is resident in a different country
     * than the Platform.
     *
     * Allowed values: true, false.
     * @var bool
     */
    public $ForeignRetailerIndicator;

    /**
     * The transaction amount related to a foreign Seller. When provided, the
     * value must be less than or equal to the DebitedFunds.Amount.
     * @var Money
     */
    public $ForeignRetailerAmount;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['ForeignRetailerAmount'] = '\MangoPay\Money';

        return $subObjects;
    }
}
