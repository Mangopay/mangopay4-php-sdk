<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class Check extends Dto
{
    /**
     * The unique identifier of the verification check.
     * @var string
     */
    public $CheckId;

    /**
     * Type of verification check performed:
     *  <p>BUSINESS_VERIFICATION - Verification of the business entity of a Legal User.</p>
     *  <p>IDENTITY_DOCUMENT_VERIFICATION - Verification of the identity document of a Natural User or the legal representative of a Legal User.</p>
     *  <p>PERSONS_SIGNIFICANT_CONTROL - Verification of a person of significant control of a Legal User.</p>
     * @var string
     */
    public $Type;

    /**
     * Returned values: VALIDATED, REFUSED, REVIEW
     * @var string
     */
    public $CheckStatus;

    /**
     * The date and time at which the check was created.
     * @var int
     */
    public $CreationDate;

    /**
     * The date and time at which the check was last updated.
     * @var int
     */
    public $LastUpdate;

    /**
     * The data points collected and verified during the check.
     * @var CheckData[]
     */
    public $Data;

    /**
     * The data points collected and verified during the check.
     * @var CheckData[]
     */
    public $Reasons;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Data'] = ['array_single', '\MangoPay\CheckData'];
        $subObjects['Reasons'] = ['array_single', '\MangoPay\CheckData'];

        return $subObjects;
    }
}
