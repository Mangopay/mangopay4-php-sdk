<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class SettlementValidationFooter extends Dto
{
    /**
     * @var string|null
     */
    public $FooterName;

    /**
     * @var string|null
     */
    public $Code;

    /**
     * @var string|null
     */
    public $Description;
}