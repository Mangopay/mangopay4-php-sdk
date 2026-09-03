<?php

namespace MangoPay;

/**
 * Class represents Web type for 'DIRECT' execution option in PayIn entity
 */
class PayInExecutionDetailsDirect extends Libraries\Dto implements PayInExecutionDetails
{
    /**
     * SecureMode { DEFAULT, FORCE, NO_CHOICE }
     * @var string
     */
    public $SecureMode;

    /**
     * SecureModeReturnURL
     * @var string
     */
    public $SecureModeReturnURL;

    /**
     * SecureModeRedirectURL
     * @var string
     */
    public $SecureModeRedirectURL;

    /**
    * SecureModeNeeded
    * @var bool
    */
    public $SecureModeNeeded;

    /**
     * Billing information
     * @var Billing
     */
    public $Billing;

    /**
     * Security & validation information
     * @var SecurityInfo
     */
    public $SecurityInfo;

    /**
     * The language to use for the payment page - needs to be the ISO code of the language
     * @var string
     */
    public $Culture;

    /**
     * Requested3DSVersion
     * @var string
     */
    public $Requested3DSVersion;

    /**
     * Applied3DSVersion
     * @var string
     */
    public $Applied3DSVersion;

    /**
     * Card Id
     * @var string
     */
    public $CardId;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Billing'] = '\MangoPay\Billing';
        $subObjects['SecurityInfo'] = '\MangoPay\SecurityInfo';

        return $subObjects;
    }
}
