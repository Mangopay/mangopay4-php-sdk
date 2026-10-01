<?php

namespace MangoPay;

/**
 * UserNatural entity
 */
class UserNaturalSca extends User
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
     * Format: International telephone numbering plan E.164 (+ then country code then the number) or local format
     * <p>
     * Required if UserCategory is OWNER.
     * <p>
     * The individual’s phone number.
     * <p>
     * If the international format is sent, the PhoneNumberCountry value is not taken into account.
     * <p>
     * We recommend that you use the PhoneNumberCountry parameter to ensure the correct rendering in line with the E.164 standard.
     * <p>
     * Caution: If UserCategory is OWNER, modifying this value means the user will be required to re-enroll the new value in SCA via the PendingUserAction.RedirectUrl.
     * For more details see the <a href="https://docs.mangopay.com/guides/users/sca/enrollment">SCA</a> guides.
     * @var string
     */
    public $PhoneNumber;

    /**
     * Allowed values: Two-letter country code (ISO 3166-1 alpha-2 format).
     * <p>
     * Required if the PhoneNumber is provided in local format.
     * <p>
     * The country code of the PhoneNumber, used to render the value in the E.164 standard.
     * <p>
     * Caution: If UserCategory is OWNER, modifying this value means the user will be required to re-enroll the new value in SCA via the PendingUserAction.RedirectUrl.
     * For more details see the <a href="https://docs.mangopay.com/guides/users/sca/enrollment">SCA</a> guides.
     * @var string
     */
    public $PhoneNumberCountry;

    /**
     * Information about the action required from the user if UserStatus is PENDING_USER_ACTION (otherwise returned null).
     * @var PendingUserAction|null
     */
    public $PendingUserAction;

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
        $subObjects['PendingUserAction'] = '\MangoPay\PendingUserAction';

        return $subObjects;
    }
}
