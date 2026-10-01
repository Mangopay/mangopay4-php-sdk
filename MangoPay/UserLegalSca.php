<?php

namespace MangoPay;

/**
 * UserLegal entity
 */
class UserLegalSca extends User
{
    /**
     * Headquarters address.
     * @var Address
     */
    public $HeadquartersAddress;

    /**
     * Legal Representative address.
     * @var Address
     */
    public $LegalRepresentativeAddress;

    /**
     * Name of user
     * @var string
     */
    public $Name;

    /**
     * Type for legal user. Possible: BUSINESS, PARTNERSHIP, ORGANIZATION, SOLETRADER
     * @var string
     */
    public $LegalPersonType;

    /**
     * Proof of registration.
     * @var string
     */
    public $ProofOfRegistration;

    /**
     * Shareholder declaration.
     * @var string
     */
    public $ShareholderDeclaration;

    /**
     * Statute.
     * @var string
     */
    public $Statute;

    /**
     * Company number.
     * @var string
     */
    public $CompanyNumber;

    /**
     * Information about the action required from the user if UserStatus is PENDING_USER_ACTION (otherwise returned null).
     * @var PendingUserAction|null
     */
    public $PendingUserAction;

    /**
     * Information about the legal representative declared for the user.
     * @var LegalRepresentative
     */
    public $LegalRepresentative;

    /**
     * @var string|null
     * If provided, possible values: USER_PRESENT, USER_NOT_PRESENT.
     */
    public $ScaContext;

    /**
     * @var string
     */
    public $ProfilingAttemptReference;

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
        $subObjects['PendingUserAction'] = '\MangoPay\PendingUserAction';
        $subObjects['LegalRepresentative'] = '\MangoPay\LegalRepresentative';

        return $subObjects;
    }
}
