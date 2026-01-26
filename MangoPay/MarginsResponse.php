<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class MarginsResponse extends Dto
{
    /**
     * @var UserMargin
     */
    public $Mangopay;

    /**
     * @var UserMargin|null
     */
    public $User;
}
