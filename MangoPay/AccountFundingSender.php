<?php

namespace MangoPay;

class AccountFundingSender extends Libraries\Dto
{
    /**
     * @var string
     */
    public $FirstName;

    /**
     * @var string
     */
    public $LastName;

    /**
     * @var \MangoPay\Address
     */
    public $Address;

    /**
     * @var string
     */
    public $Email;

    /**
     * @var int
     */
    public $Birthday;

    /**
     * @var string
     */
    public $Nationality;

    /**
     * @var string
     */
    public $Occupation;

    /**
     * @var string
     */
    public $BirthCountry;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Address'] = '\MangoPay\Address';

        return $subObjects;
    }
}
