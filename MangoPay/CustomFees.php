<?php

namespace MangoPay;

class CustomFees extends Money
{
    /**
     * Property used for specifying fees.
     * Defines how the fee is calculated (PERCENTAGE or FIXED)
     * @var string
     */
    public $Type;

    /**
     * The fee amount or percentage.
     * @var int
     */
    public $Value;
}
