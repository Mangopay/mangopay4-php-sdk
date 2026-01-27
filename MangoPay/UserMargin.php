<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class UserMargin extends Dto
{
    /**
     * Defines the calculation model.
     * <p>PERCENTAGE: The margin is a percentage of the transaction amount.</p>
     * <p>PIP: The margin is defined in pips.</p>
     * @var string
     */
    public $Type;

    /**
     * The numerical value for the margin
     * @var double
     */
    public $Value;

    /**
     * @var int|null
     */
    public $Amount;
}
