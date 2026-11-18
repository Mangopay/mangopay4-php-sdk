<?php

namespace MangoPay;

class PayInReferences extends Libraries\Dto
{
    /**
     * The type of the reference, e.g. EndToEndId.
     * @var string
     */
    public $Type;

    /**
     * The value of the reference.
     * @var string
     */
    public $Value;
}
