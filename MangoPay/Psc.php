<?php

namespace MangoPay;

class Psc extends Libraries\EntityBase
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
     * @var string
     */
    public $Email;

    /**
     * @var int
     */
    public $DateOfBirth;

    /**
     * @var string
     */
    public $Country;

    /**
     * @var string
     */
    public $Nationality;

    /**
     * @var string
     */
    public $PscType;

    /**
     * @var string
     */
    public $Status;

    /**
     * @var int
     */
    public $ValidationDate;

    /**
     * @var string
     */
    public $HostedUrl;

    /**
     * @var PscData[]
     */
    public $Data;

    /**
     * @var int
     */
    public $LastUpdate;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Data'] = ['array_single', '\MangoPay\PscData'];

        return $subObjects;
    }
}
