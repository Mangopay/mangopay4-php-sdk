<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for card registrations
 */
class ApiCardRegistrations extends Libraries\ApiBase
{
    /**
     * Create new card registration
     * @param CardRegistration $cardRegistration Card registration object to create
     * @return CardRegistration Card registration object returned from API
     */
    public function Create($cardRegistration, $idempotencyKey = null)
    {
        return $this->CreateObject('cardregistration_create', $cardRegistration, '\MangoPay\CardRegistration', null, null, $idempotencyKey);
    }

    /**
     * Get card registration
     * @param string $cardRegistrationId Card Registration identifier
     * @return CardRegistration Card registration  object returned from API
     */
    public function Get($cardRegistrationId)
    {
        return $this->GetObject('cardregistration_get', '\MangoPay\CardRegistration', $cardRegistrationId);
    }

    /**
     * Update card registration
     * @param CardRegistration $cardRegistration Card registration object to save
     * @return CardRegistration Card registration object returned from API
     */
    public function Update($cardRegistration)
    {
        return $this->SaveObject('cardregistration_save', $cardRegistration, '\MangoPay\CardRegistration');
    }
}
