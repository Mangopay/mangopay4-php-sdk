<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for cards
 */
class ApiCards extends Libraries\ApiBase
{
    /**
     * Get card
     * @param string $cardId Card identifier
     * @return Card object returned from API
     */
    public function Get($cardId)
    {
        return $this->GetObject('card_get', '\MangoPay\Card', $cardId);
    }

    /**
     * Gets a list of cards having the same fingerprint.
     * The fingerprint is a hash uniquely generated per 16-digit card number.
     *
     * @param string $fingerprint The fingerprint hash
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Sorting object
     * @return Card[] List of Cards corresponding to provided fingerprint
     */
    public function GetByFingerprint($fingerprint, & $pagination = null, $sorting = null)
    {
        return $this->GetList('cards_get_by_fingerprint', $pagination, '\MangoPay\Card', $fingerprint, null, $sorting);
    }

    /**
     * Update card
     * @param Card $card Card object to save
     * @return Card Card object returned from API
     */
    public function Update($card)
    {
        return $this->SaveObject('card_save', $card, '\MangoPay\Card');
    }

    /**
     * Gets a Card's PreAuthorizations
     * @param int $cardId ID of the Card for which to retrieve PreAuthorizations
     * @param Pagination $pagination Pagination object
     * @param FilterPreAuthorizations $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return CardPreAuthorization[] List of the Card's PreAuthorizations
     */
    public function GetPreAuthorizations($cardId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList("preauthorizations_get_for_card", $pagination, '\MangoPay\CardPreAuthorization', $cardId, $filter, $sorting);
    }

    /**
     * Retrieves a list of Transactions pertaining to a certain Card
     * @param string $cardId Card identifier
     * @param Pagination $pagination Pagination object
     * @param FilterTransactions $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Transaction[]
     */
    public function GetTransactions($cardId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('transactions_get_for_card', $pagination, '\MangoPay\Transaction', $cardId, $filter, $sorting);
    }

    /**
     * Validate a card
     * @param $cardId
     * @return CardValidation
     * @throws Libraries\Exception
     */
    public function ValidateCard($cardId, $cardValidation)
    {
        return $this->ExecutePostRequest('card_validate', $cardValidation, '\MangoPay\CardValidation', $cardId);
    }

    /**
     * Get card validation
     * @param $cardId, $cardValidationId
     * @return Card
     * @throws Libraries\Exception
     */
    public function GetCardValidation($cardId, $cardValidationId)
    {
        return $this->GetObject('get_card_validation', '\MangoPay\CardValidation', $cardId, $cardValidationId);
    }

    /**
     * Gets a list of transactions having for a card fingerprint.
     * The fingerprint is a hash uniquely generated per 16-digit card number.
     *
     * @param string $fingerprint The fingerprint hash
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Sorting object
     * @param FilterTransactions $filter Filter object
     * @return Transaction[] List of Transactions corresponding to provided fingerprint
     */
    public function GetTransactionsByFingerprint($fingerprint, $filter = null, $pagination = null, $sorting = null)
    {
        return $this->GetList(
            'transactions_get_by_fingerprint',
            $pagination,
            '\MangoPay\Transaction',
            $fingerprint,
            $filter,
            $sorting
        );
    }
}
