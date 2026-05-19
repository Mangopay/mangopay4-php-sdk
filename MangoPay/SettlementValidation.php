<?php

namespace MangoPay;

use MangoPay\Libraries\EntityBase;

class SettlementValidation extends EntityBase
{
    /**
     * @var SettlementValidationFooter[]|null
     */
    public $FooterErrors;

    /**
     * @var SettlementValidationLine[]|null
     */
    public $LinesErrors;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['FooterErrors'] = ['array_single', '\MangoPay\SettlementValidationFooter'];
        $subObjects['LinesErrors'] = ['array_single', '\MangoPay\SettlementValidationLine'];

        return $subObjects;
    }
}
