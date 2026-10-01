<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for extended preauthorizations
 */
class ApiExtendedPreauthorizations extends Libraries\ApiBase
{
    /**
     * Create Extended Preauthorization
     * @param ExtendedPreauthorization $extendedPreauthorization ExtendedPreauthorization object to save
     * @return ExtendedPreauthorization ExtendedPreauthorization object returned from API
     */
    public function Create(ExtendedPreauthorization $extendedPreauthorization, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'extended_preauthorizations_create',
            $extendedPreauthorization,
            '\MangoPay\ExtendedPreauthorization',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Create PayPal Extended Preauthorization
     * @param PayPalExtendedPreauthorization $extendedPreauthorization ExtendedPreauthorization object to save
     * @return PayPalExtendedPreauthorization ExtendedPreauthorization object returned from API
     */
    public function CreatePayPalExtendedPreauthorization(PayPalExtendedPreauthorization $extendedPreauthorization, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'extended_preauthorizations_create_paypal',
            $extendedPreauthorization,
            '\MangoPay\PayPalExtendedPreauthorization',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Get Extended Preauthorization. Returns a PayPalExtendedPreauthorization instance when the
     * underlying preauthorization was created via PayPal, otherwise an ExtendedPreauthorization instance.
     * @param string $extendedPreauthorizationId ExtendedPreauthorization identifier
     * @return ExtendedPreauthorization|PayPalExtendedPreauthorization ExtendedPreauthorization object returned from API
     */
    public function Get($extendedPreauthorizationId)
    {
        $response = $this->GetObject('extended_preauthorizations_get', null, $extendedPreauthorizationId);
        return $this->CastResponseToEntity($response, $this->ResolveExtendedPreauthorizationClass($response));
    }

    /**
     * Update Extended Preauthorization. Returns a PayPalExtendedPreauthorization instance when the
     * underlying preauthorization was created via PayPal, otherwise an ExtendedPreauthorization instance.
     * @param ExtendedPreauthorization $extendedPreauthorization Extended preauthorization to update, with its Id set
     * @return ExtendedPreauthorization|PayPalExtendedPreauthorization ExtendedPreauthorization object returned from API
     */
    public function Update(ExtendedPreauthorization $extendedPreauthorization)
    {
        $response = $this->SaveObject('extended_preauthorizations_update', $extendedPreauthorization);
        return $this->CastResponseToEntity($response, $this->ResolveExtendedPreauthorizationClass($response));
    }

    /**
     * Get all extended preauthorizations for a user. PayPal items are returned as
     * PayPalExtendedPreauthorization instances; others as ExtendedPreauthorization.
     * @param string $userId User identifier
     * @param Pagination $pagination Pagination object
     * @param FilterPreAuthorizations $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return ExtendedPreauthorization[]|PayPalExtendedPreauthorization[] ExtendedPreauthorization list returned from API
     */
    public function GetAllForUser($userId, $pagination = null, $filter = null, $sorting = null)
    {
        $response = $this->GetList('extended_preauthorizations_get_all_for_user', $pagination, null, $userId, $filter, $sorting);
        $list = [];
        if (is_array($response)) {
            foreach ($response as $item) {
                $list[] = $this->CastResponseToEntity($item, $this->ResolveExtendedPreauthorizationClass($item));
            }
        }
        return $list;
    }

    /**
     * Get all extended preauthorizations for a card
     * @param string $cardId Card identifier
     * @param Pagination $pagination Pagination object
     * @param FilterPreAuthorizations $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return ExtendedPreauthorization[] ExtendedPreauthorization list returned from API
     */
    public function GetAllForCard($cardId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('extended_preauthorizations_get_all_for_card', $pagination, '\MangoPay\ExtendedPreauthorization', $cardId, $filter, $sorting);
    }

    /**
     * Get all transactions for an extended preauthorization
     * @param string $extendedPreauthorizationId ExtendedPreauthorization identifier
     * @param Pagination $pagination Pagination object
     * @param FilterTransactions $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Transaction[] Transaction list returned from API
     */
    public function GetTransactions($extendedPreauthorizationId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('extended_preauthorizations_get_transactions', $pagination, '\MangoPay\Transaction', $extendedPreauthorizationId, $filter, $sorting);
    }

    private function ResolveExtendedPreauthorizationClass($rawResponse)
    {
        if (is_object($rawResponse)
            && isset($rawResponse->PaymentType)
            && $rawResponse->PaymentType === PayInPaymentType::PayPal) {
            return '\MangoPay\PayPalExtendedPreauthorization';
        }
        return '\MangoPay\ExtendedPreauthorization';
    }
}
