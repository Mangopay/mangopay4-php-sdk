<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for Identity Verification Sessions
 */
class ApiIdentityVerification extends Libraries\ApiBase
{
    /**
     * Create new IdentityVerification
     * @param IdentityVerification $identityVerification
     * @return \MangoPay\IdentityVerification IdentityVerification object returned from API
     */
    public function Create($identityVerification, $userId, $idempotencyKey = null)
    {
        return $this->CreateObject('identity_verification_create', $identityVerification, '\MangoPay\IdentityVerification', $userId, null, $idempotencyKey);
    }

    /**
     * Get IdentityVerification
     * @param string $id IdentityVerification identifier
     * @return \MangoPay\IdentityVerification IdentityVerification object returned from API
     */
    public function Get($id)
    {
        return $this->GetObject('identity_verification_get', '\MangoPay\IdentityVerification', $id);
    }

    /**
     * Get all IdentityVerifications for a user
     * @param string $userId User identifier
     * @return \MangoPay\IdentityVerification[] IdentityVerification list returned from API
     */
    public function GetAll($userId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('identity_verification_get_all', $pagination, '\MangoPay\IdentityVerification', $userId, $filter, $sorting);
    }

    /**
     * Request the retry of a PSC session
     * @param string $identityVerificationId The unique identifier of the identity verification
     * @param string $pscId The unique identifier of the PSC
     * @param Psc $psc PSC object; it can be empty or contain values to be updated
     * @return \MangoPay\Psc Updated Psc object returned from API
     */
    public function RetryPsc($identityVerificationId, $pscId, $psc = null)
    {
        if (is_null($psc)) {
            $psc = new Psc();
        }

        return $this->UpdateObject('identity_verification_retry_psc', $psc, '\MangoPay\Psc', $identityVerificationId, $pscId);
    }
}
