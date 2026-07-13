<?php

namespace MangoPay;

/**
 * UserNatural entity
 */
class UserNatural extends User
{
    /**
     * First name for user
     * @var string
     */
    public $FirstName;

    /**
    * Last name for user
    * @var string
    */
    public $LastName;

    /**
    * Address for user
    * @var Address
    */
    public $Address;

    /**
    * Date of birth
    * @var int Unix timestamp
    */
    public $Birthday;

    /**
    * User's country
    * @var string
    */
    public $Nationality;

    /**
    * Country of residence
    * @var string
    */
    public $CountryOfResidence;

    /**
     * User's occupation
     * @var string
     */
    public $Occupation;

    /**
     *
     * @var int
     */
    public $IncomeRange;

    /**
     *
     * @var string
     */
    public $ProofOfIdentity;

    /**
     *
     * @var string
     */
    public $ProofOfAddress;

    /**
     * Capacity of the user within MangoPay
     * Takes values from \MangoPay\NaturalUserCapacity
     * @var string
     */
    public $Capacity;

    /**
     * Construct
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->SetPersonType(PersonType::Natural);
    }

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

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'ProofOfIdentity');
        array_push($properties, 'ProofOfAddress');

        return $properties;
    }
}
