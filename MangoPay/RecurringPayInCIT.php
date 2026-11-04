<?php

namespace MangoPay;

class RecurringPayInCIT extends Libraries\Dto
{
    /**
     * @var string
     */
    public $RecurringPayinRegistrationId;

    /**
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * @var string
     */
    public $IpAddress;

    /**
     * @var string
     */
    public $SecureModeReturnURL;

    /**
     * @var string
     */
    public $StatementDescriptor;

    /**
     * @var string
     */
    public $Tag;

    /**
     * @var Money
     */
    public $DebitedFunds;

    /**
     * @var Money
     */
    public $Fees;

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
        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['Fees'] = '\MangoPay\Money';
        $subObjects['MarketplaceData'] = '\MangoPay\MarketplaceData';

        return $subObjects;
    }
}
