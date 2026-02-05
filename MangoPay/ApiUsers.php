<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API calls for the user entity.
 */
class ApiUsers extends Libraries\ApiBase
{
    /**
     * Create a new user
     * @param UserLegal|UserNatural|UserNaturalSca|UserLegalSca $user
     * @return UserLegal|UserNatural|UserNaturalSca|UserLegalSca User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Create($user, $idempotencyKey = null)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural') {
            $methodKey = 'users_createnaturals';
        } elseif ($className == 'MangoPay\UserNaturalSca') {
            $methodKey = 'users_createnaturals_sca';
        } elseif ($className == 'MangoPay\UserLegal') {
            $methodKey = 'users_createlegals';
        } elseif ($className == 'MangoPay\UserLegalSca') {
            $methodKey = 'users_createlegals_sca';
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $response = $this->CreateObject($methodKey, $user, null, null, null, $idempotencyKey);
        return $this->GetUserResponse($response);
    }

    /**
     * Get all users
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return UserLegal[]|UserNatural[] Array with users
     */
    public function GetAll(& $pagination = null, $sorting = null)
    {
        $usersList = $this->GetList('users_all', $pagination, null, null, null, $sorting);

        $users = [];
        if (is_array($usersList)) {
            foreach ($usersList as $user) {
                array_push($users, $this->GetUserResponse($user));
            }
        }
        return $users;
    }

    /**
     * Get natural or legal user by ID
     * @param string $userId User identifier
     * @return UserLegal|UserNatural User object returned from API
     */
    public function Get($userId)
    {
        $response = $this->GetObject('users_get', null, $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get SCA natural or legal user by ID
     * @param string $userId User identifier
     * @return UserNaturalSca|UserLegalSca User object returned from API
     */
    public function GetSca($userId)
    {
        $response = $this->GetObject('users_get_sca', null, $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get natural user by ID
     * @param string $userId User identifier
     * @return UserNatural User object returned from API
     */
    public function GetNatural($userId)
    {
        $response = $this->GetObject('users_getnaturals', null, $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get SCA natural user by ID
     * @param string $userId User identifier
     * @return UserNaturalSca User object returned from API
     */
    public function GetNaturalSca($userId)
    {
        $response = $this->GetObject('users_getnaturals_sca', null, $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get legal user by ID
     * @param string $userId User identifier
     * @return UserLegal User object returned from API
     */
    public function GetLegal($userId)
    {
        $response = $this->GetObject('users_getlegals', null, $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get SCA legal user by ID
     * @param string $userId User identifier
     * @return UserLegalSca User object returned from API
     */
    public function GetLegalSca($userId)
    {
        $response = $this->GetObject('users_getlegals_sca', null, $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Save user
     * @param UserLegal|UserNatural $user
     * @return UserLegal|UserNatural User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Update($user)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural') {
            $methodKey = 'users_savenaturals';
            if (!is_null($user->Address)
                && is_a($user->Address, "MangoPay\Address")
                && $user->Address->CanBeNull()) {
                $user->Address = null;
            }
        } elseif ($className == 'MangoPay\UserLegal') {
            $methodKey = 'users_savelegals';
            if (!is_null($user->HeadquartersAddress)
                && is_a($user->HeadquartersAddress, "MangoPay\Address")
                && $user->HeadquartersAddress->CanBeNull()) {
                $user->HeadquartersAddress = null;
            }
            if (!is_null($user->LegalRepresentativeAddress)
                && is_a($user->LegalRepresentativeAddress, "MangoPay\Address")
                && $user->LegalRepresentativeAddress->CanBeNull()) {
                $user->LegalRepresentativeAddress = null;
            }
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }

    /**
     * Update SCA user
     * @param UserLegalSca|UserNaturalSca $user
     * @return UserLegalSca|UserNaturalSca User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function UpdateSca($user)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNaturalSca') {
            $methodKey = 'users_savenaturals_sca';
            if (!is_null($user->Address)
                && is_a($user->Address, "MangoPay\Address")
                && $user->Address->CanBeNull()) {
                $user->Address = null;
            }
        } elseif ($className == 'MangoPay\UserLegalSca') {
            $methodKey = 'users_savelegals_sca';
            if (!is_null($user->HeadquartersAddress)
                && is_a($user->HeadquartersAddress, "MangoPay\Address")
                && $user->HeadquartersAddress->CanBeNull()) {
                $user->HeadquartersAddress = null;
            }
            if (!is_null($user->LegalRepresentativeAddress)
                && is_a($user->LegalRepresentativeAddress, "MangoPay\Address")
                && $user->LegalRepresentativeAddress->CanBeNull()) {
                $user->LegalRepresentativeAddress = null;
            }
            if (!is_null($user->LegalRepresentative)
                && is_a($user->LegalRepresentative, "MangoPay\LegalRepresentative")
                && $user->LegalRepresentative->CanBeNull()) {
                $user->LegalRepresentative = null;
            }
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }

    /**
     * Transition a Natural/Legal Payer to Owner (SCA).
     * Some parameters may be required based on the kind of transition you do.
     * @param UserLegalSca|UserNaturalSca|UserLegal|UserNatural $user
     * @return UserLegalSca|UserNaturalSca|UserLegal|UserNatural User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Categorize($user)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNaturalSca' || $className == 'MangoPay\UserNatural') {
            $methodKey = 'users_categorizenaturals_sca';
        } elseif ($className == 'MangoPay\UserLegalSca' || $className == 'MangoPay\UserLegal') {
            $methodKey = 'users_categorizelegals_sca';
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }

    /**
     * Create bank account for user
     * @param string $userId User Id
     * @param \MangoPay\BankAccount $bankAccount Entity of bank account object
     * @return \MangoPay\BankAccount Create bank account object
     */
    public function CreateBankAccount($userId, $bankAccount, $idempotencyKey = null)
    {
        $type = $this->GetBankAccountType($bankAccount);
        return $this->CreateObject('users_createbankaccounts_' . $type, $bankAccount, '\MangoPay\BankAccount', $userId, null, $idempotencyKey);
    }

    /**
     * Get all bank accounts for user
     * @param string $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterBankAccounts $filter Filtering object
     *
     * @return \MangoPay\BankAccount[] Array with bank account entities
     */
    public function GetBankAccounts($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('users_allbankaccount', $pagination, 'MangoPay\BankAccount', $userId, $filter, $sorting);
    }

    /**
     * Get bank account for user
     * @param string $userId User Id
     * @param string $bankAccountId Bank account Id
     *
     * @return \MangoPay\BankAccount Entity of bank account object
     */
    public function GetBankAccount($userId, $bankAccountId)
    {
        return $this->GetObject('users_getbankaccount', 'MangoPay\BankAccount', $userId, $bankAccountId);
    }

    /**
     * Save a bank account
     * @param string $userId
     * @param \MangoPay\BankAccount $bankAccount
     * @return \MangoPay\BankAccount Entity of bank account object
     */
    public function UpdateBankAccount($userId, $bankAccount)
    {
        return $this->SaveObject('bankaccounts_save', $bankAccount, '\MangoPay\BankAccount', $userId);
    }

    /**
     * Get all wallets for user
     * @param string $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Wallet[] Array with objects returned from API
     */
    public function GetWallets($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('users_allwallets', $pagination, 'MangoPay\Wallet', $userId, $filter, $sorting);
    }

    /**
     * Get all transactions for user
     * @param string $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Transaction[] Transactions for user returned from API
     */
    public function GetTransactions($userId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_alltransactions', $pagination, '\MangoPay\Transaction', $userId, $filter, $sorting);
    }

    /**
     * Get all cards for user
     * @param string $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterCards $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Card[] Cards for user returned from API
     */
    public function GetCards($userId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_allcards', $pagination, '\MangoPay\Card', $userId, $filter, $sorting);
    }

    /**
     * Create new KYC document
     * @param string $userId User Id
     * @param \MangoPay\KycDocument $kycDocument
     * @param string $idempotencyKey Key for response replication
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function CreateKycDocument($userId, $kycDocument, $idempotencyKey = null)
    {
        return $this->CreateObject('kyc_documents_create', $kycDocument, '\MangoPay\KycDocument', $userId, null, $idempotencyKey);
    }

    /**
     * Get all KYC documents for user
     * @param string $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterKycDocuments $filter Object to filter data
     *
     * @return \MangoPay\KycDocument[] Array with KYC documents entities
     */
    public function GetKycDocuments($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('users_allkycdocuments', $pagination, 'MangoPay\KycDocument', $userId, $filter, $sorting);
    }

    /**
     * Get KYC document
     * @param string $userId User Id
     * @param string $kycDocumentId Document identifier
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function GetKycDocument($userId, $kycDocumentId)
    {
        return $this->GetObject('kyc_documents_get', '\MangoPay\KycDocument', $userId, $kycDocumentId);
    }

    /**
     * Get all mandates for user
     * @param string $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Mandate[] Array with mandate entities
     */
    public function GetMandates($userId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_allmandates', $pagination, 'MangoPay\Mandate', $userId, $filter, $sorting);
    }

    /**
     * Get mandates for user and bank account
     * @param string $userId User Id
     * @param string $bankAccountId Bank account Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Mandate[] Array with mandate entities
     */
    public function GetMandatesForBankAccount($userId, $bankAccountId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_allbankaccount_mandates', $pagination, 'MangoPay\Mandate', $userId, $filter, $sorting, $bankAccountId);
    }

    /**
     * Save KYC document
     * @param string $userId User Id
     * @param \MangoPay\KycDocument $kycDocument Document to save
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function UpdateKycDocument($userId, $kycDocument)
    {
        return $this->SaveObject('kyc_documents_save', $kycDocument, '\MangoPay\KycDocument', $userId);
    }

    /**
     * Create page for Kyc document
     * @param string $userId User Id
     * @param string $kycDocumentId KYC Document Id
     * @param \MangoPay\KycPage $kycPage KYC Page
     * @return true always true. If an error occurred, a \MangoPay\Libraries\Exception is thrown
     * @throws \MangoPay\Libraries\Exception
     */
    public function CreateKycPage($userId, $kycDocumentId, $kycPage, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('kyc_page_create', $kycPage, null, $userId, $kycDocumentId, $idempotencyKey);
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }

        return true;
    }

    /**
     * Create page for Kyc document from file
     * @param string $userId User Id
     * @param string $kycDocumentId KYC Document Id
     * @param string $filePath File path
     * @return true always true. If an error occurred, a \MangoPay\Libraries\Exception is thrown
     * @throws \MangoPay\Libraries\Exception
     */
    public function CreateKycPageFromFile($userId, $kycDocumentId, $filePath, $idempotencyKey = null)
    {
        if (empty($filePath)) {
            throw new \MangoPay\Libraries\Exception('Path of file cannot be empty');
        }

        if (!file_exists($filePath)) {
            throw new \MangoPay\Libraries\Exception('File not exist');
        }

        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = base64_encode(file_get_contents($filePath));

        if (empty($kycPage->File)) {
            throw new \MangoPay\Libraries\Exception('Content of the file cannot be empty');
        }

        return $this->CreateKycPage($userId, $kycDocumentId, $kycPage, $idempotencyKey);
    }

    /**
     * Get user EMoney
     * @param string $userId User Id
     * @param $year
     * @param $month
     * @return \MangoPay\EMoney EMoney object returned from API
     * @throws Libraries\Exception
     */
    public function GetEMoney($userId, $year = null, $month = null)
    {
        if ($year == null) {
            $year = $this->GetCurrentYear();
        }

        $methodKey = $month == null ? 'users_getemoney_year' : 'users_getemoney_month';
        return $this->GetObject($methodKey, '\MangoPay\EMoney', $userId, $year, $month);
    }

    /**
     * Get the current year
     * @return int currentYear
     */
    private function GetCurrentYear()
    {
        return (new \DateTime())->format("Y");
    }

    /**
     * Gets a list with PreAuthorizations belonging to a specific user
     * @param string $userId ID of the user whose PreAuthorizations to retrieve
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterPreAuthorizations $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\CardPreAuthorization[] The user's PreAuthorizations
     */

    public function GetPreAuthorizations($userId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('preauthorizations_get_for_user', $pagination, '\MangoPay\CardPreAuthorization', $userId, $filter, $sorting);
    }

    /**
     * Get correct user object
     * @param object $response Response from API
     * @return UserLegal|UserNatural|UserNaturalSca|UserLegalSca User object returned from API
     * @throws \MangoPay\Libraries\Exception If occur unexpected response from API
     */
    private function GetUserResponse($response)
    {
        if (isset($response->PersonType)) {
            switch ($response->PersonType) {
                case PersonType::Natural:
                    // if the json has SCA related properties -> deserialize to UserNaturalSca
                    // !!! THIS LOGIC SHOULD NOT BE CHANGED ON API SIDE !!!
                    if (property_exists($response, "PendingUserAction")) {
                        return $this->CastResponseToEntity($response, '\MangoPay\UserNaturalSca');
                    }
                    return $this->CastResponseToEntity($response, '\MangoPay\UserNatural');
                case PersonType::Legal:
                    // if the json has SCA related properties -> deserialize to UserLegalSca
                    // !!! THIS LOGIC SHOULD NOT BE CHANGED ON API SIDE !!!
                    if (property_exists($response, "PendingUserAction")) {
                        return $this->CastResponseToEntity($response, '\MangoPay\UserLegalSca');
                    }
                    return $this->CastResponseToEntity($response, '\MangoPay\UserLegal');
                default:
                    throw new Libraries\Exception('Unexpected response. Wrong PersonType value');
            }
        } else {
            throw new Libraries\Exception('Unexpected response. Missing PersonType property');
        }
    }

    private function GetBankAccountType($bankAccount)
    {
        if (!isset($bankAccount->Details) || !is_object($bankAccount->Details)) {
            throw new Libraries\Exception('Details is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\BankAccountDetails', '', get_class($bankAccount->Details));
        return strtolower($className);
    }

    /**
     * Get the Block Status of a User
     * @param string $userId User identifier
     * @return UserBlockStatus User object returned from API
     */
    public function GetBlockStatus($userId)
    {
        return $this->GetObject('users_block_status', 'MangoPay\UserBlockStatus', $userId);
    }

    /**
     * Get the Block Status Regulatory  of a User
     * @param string $userId User identifier
     * @return UserBlockStatus User object returned from API
     */
    public function GetRegulatory($userId)
    {
        return $this->GetObject('users_block_status_regulatory', 'MangoPay\UserBlockStatus', $userId);
    }

    /**
     * This call allows you to check the validity of the format
     * of a piece of user data, and to retrieve the validation rules applied to it.
     * @param $companyNumberDetails
     * @return \MangoPay\CompanyNumberDetails
     */
    public function ValidateTheFormatOfUserData($companyNumberDetails)
    {
        return $this->ExecutePostRequest('validate_the_format_of_user_data', $companyNumberDetails, '\MangoPay\CompanyNumberDetails');
    }

    /**
     * If UserCategory is OWNER, this endpoint allows you to enroll a user in SCA.
     * Your platform needs to retrieve the returned PendingUserAction.RedirectUrl,
     * add an encoded returnUrl query parameter for them to be returned to after the SCA session, and redirect the user.
     * @param string $userId
     * @return UserEnrollmentResult User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Enroll($userId, $idempotencyKey = null)
    {
        return $this->ExecutePostRequest(
            'users_enroll_sca',
            new UserNatural(),
            '\MangoPay\UserEnrollmentResult',
            $userId,
            $idempotencyKey
        );
    }

    /**
     * Manage user consent
     *
     * @param string $userId
     * @return UserConsent User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function ManageConsent($userId, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'users_manage_consent',
            null,
            '\MangoPay\UserConsent',
            $userId,
            null,
            $idempotencyKey
        );
    }

    /**
     * Close user (change status to CLOSED). The resource remains available for historical purposes.
     * @param UserLegal|UserNatural|UserLegalSca|UserNaturalSca $user
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Close($user)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural' || $className == 'MangoPay\UserNaturalSca') {
            $methodKey = 'users_close_natural';
        } elseif ($className == 'MangoPay\UserLegal' || $className == 'MangoPay\UserLegalSca') {
            $methodKey = 'users_close_legal';
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $this->DeleteObject($methodKey, $user);
    }

    /**
     * Get SCA status
     * @param string $userId User identifier
     * @return ScaStatus ScaStatus object returned from API
     */
    public function GetScaStatus($userId)
    {
        return $this->GetObject('users_get_sca_status', 'MangoPay\ScaStatus', $userId);
    }
}
