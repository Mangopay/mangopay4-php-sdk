<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class SettlementValidationLine extends Dto
{
    /**
     * @var string|null
     */
    public $ExternalProviderReference;

    /**
     * @var string|null
     */
    public $ExternalTransactionType;

    /**
     * @var SettlementValidationLineDetail[]|null
     */
    public $Details;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Details'] = ['array_single', '\MangoPay\SettlementValidationLineDetail'];

        return $subObjects;
    }
}