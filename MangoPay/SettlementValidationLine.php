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
     * @var string|null
     */
    public $Code;

    /**
     * @var string|null
     */
    public $Description;
}