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
}
