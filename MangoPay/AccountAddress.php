<?php

namespace MangoPay;

class AccountAddress extends Libraries\Dto
{
    /**
     * The building number and street name of the address.
     * @var string
     */
    public $StreetName;

    /**
     * The postal code of the address.
     * @var string
     */
    public $PostCode;

    /**
     * The town or city of the address.
     * @var string
     */
    public $TownName;

    /**
     * The region, state, or county of the address.
     * @var string
     */
    public $CountrySubDivision;

    /**
     * Two-letter country code (ISO 3166-1 alpha-2 format).
     * @var string
     */
    public $Country;
}
