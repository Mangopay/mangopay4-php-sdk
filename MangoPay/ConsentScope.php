<?php

namespace MangoPay;

class ConsentScope extends Libraries\Dto
{
    /**
     * @var string|null
     */
    public $ContactInformationUpdate;

    /**
     * @var string|null
     */
    public $RecipientRegistration;

    /**
     * @var string|null
     */
    public $Transfer;

    /**
     * @var string|null
     */
    public $ViewAccountInformation;
}
