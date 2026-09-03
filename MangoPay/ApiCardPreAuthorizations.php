<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for pre-authorization process
 */
class ApiCardPreAuthorizations extends Libraries\ApiBase
{
    /**
     * Create new pre-authorization object
     * @param CardPreAuthorization $cardPreAuthorization PreAuthorization object to create
     * @return CardPreAuthorization PreAuthorization object returned from API
     */
    public function Create($cardPreAuthorization, $idempotencyKey = null)
    {
        return $this->CreateObject('preauthorization_create', $cardPreAuthorization, '\MangoPay\CardPreAuthorization', null, null, $idempotencyKey);
    }

    /**
     * Get pre-authorization object
     * @param string $cardPreAuthorizationId PreAuthorization identifier
     * @return CardPreAuthorization Card registration  object returned from API
     */
    public function Get($cardPreAuthorizationId)
    {
        return $this->GetObject('preauthorization_get', '\MangoPay\CardPreAuthorization', $cardPreAuthorizationId);
    }

    /**
     * Update pre-authorization object
     * @param CardPreAuthorization $cardPreAuthorization PreAuthorization object to save
     * @return CardPreAuthorization PreAuthorization object returned from API
     */
    public function Update($cardPreAuthorization)
    {
        return $this->SaveObject('preauthorization_save', $cardPreAuthorization, '\MangoPay\CardPreAuthorization');
    }

    public function GetTransactions($cardPreAuthorizationId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('preauthorization_transactions_get', $pagination, '\MangoPay\Transaction', $cardPreAuthorizationId, $filter, $sorting);
    }
}
