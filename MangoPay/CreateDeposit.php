<?php

namespace MangoPay;

class CreateDeposit extends Libraries\Dto
{
    /**
     * @var string
     */
    public $AuthorId;

    /**
     * @var Money
     */
    public $DebitedFunds;

    /**
     * @var string
     */
    public $CardId;

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
    public $Culture;

    /**
     * @var string
     */
    public $IpAddress;

    /**
     * BrowserInfo
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * @var Billing
     */
    public $Billing;

    /**
     * @var Shipping
     */
    public $Shipping;

    /**
     * Flow descriptor
     * @var FlowDescriptor|null
     */
    public $FlowDescriptor;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedFunds'] = '\MangoPay\Money';
        $subObjects['BrowserInfo'] = '\MangoPay\BrowserInfo';
        $subObjects['Billing'] = '\MangoPay\Billing';
        $subObjects['Shipping'] = '\MangoPay\Shipping';
        $subObjects['FlowDescriptor'] = '\MangoPay\FlowDescriptor';

        return $subObjects;
    }
}
