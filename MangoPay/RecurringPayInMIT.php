<?php

namespace MangoPay;

class RecurringPayInMIT extends Libraries\Dto
{
    /**
     * @var string
     */
    public $RecurringPayinRegistrationId;

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
    public $StatementDescriptor;

    /**
     * @var string
     */
    public $Tag;

    /**
     * @var string|null
     */
    public $PaymentCategory;

    /**
     * Declarative marketplace information used to comply with
     * Visa Marketplace reporting.
     * @var MarketplaceData
     */
    public $MarketplaceData;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['Fees'] = '\MangoPay\Money';
        $subObjects['MarketplaceData'] = '\MangoPay\MarketplaceData';

        return $subObjects;
    }
}
