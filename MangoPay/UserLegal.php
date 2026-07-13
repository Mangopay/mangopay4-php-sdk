<?php

namespace MangoPay;

/**
 * UserLegal entity
 */
class UserLegal extends User
{
    /**
     * Name of user
     * @var string
     */
    public $Name;

    /**
     * Type for legal user. Possible: ‘BUSINESS’, ’ORGANIZATION’
     * @var string
     */
    public $LegalPersonType;

    /**
     *
     * @var Address
     */
    public $HeadquartersAddress;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeFirstName;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeLastName;

    /**
     *
     * @var Address
     */
    public $LegalRepresentativeAddress;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeEmail;

    /**
     *
     * @var int Unix timestamp
     */
    public $LegalRepresentativeBirthday;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeNationality;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeCountryOfResidence;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeProofOfIdentity;

    /**
     *
     * @var string
     */
    public $Statute;

    /**
     *
     * @var string
     */
    public $ProofOfRegistration;

    /**
     *
     * @var string
     */
    public $ShareholderDeclaration;

    /**
     * @var string
     */
    public $CompanyNumber;

    /**
     * Construct
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->SetPersonType(PersonType::Legal);
    }

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['HeadquartersAddress'] = '\MangoPay\Address';
        $subObjects['LegalRepresentativeAddress'] = '\MangoPay\Address';

        return $subObjects;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'Statute');
        array_push($properties, 'ProofOfRegistration');
        array_push($properties, 'ShareholderDeclaration');

        return $properties;
    }
}
