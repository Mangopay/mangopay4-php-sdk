<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiDeposits extends Libraries\ApiBase
{
    /**
     * Create Deposit
     * @param CreateDeposit $deposit Deposit object to save
     * @return Deposit Deposit object returned from API
     */
    public function Create(CreateDeposit $deposit, $idempotencyKey = null)
    {
        return $this->CreateObject('deposits_create', $deposit,
            '\MangoPay\Deposit', null, null, $idempotencyKey);
    }

    /**
     * Get Deposit
     * @param string $depositId Deposit identifier
     * @return Deposit Deposit object returned from API
     */
    public function Get($depositId)
    {
        return $this->GetObject('deposits_get', '\MangoPay\Deposit', $depositId);
    }

    /**
     * Cancel Deposit
     * @param string $depositId Deposit identifier
     * @param CancelDeposit $dto Cancel deposit body
     * @return Deposit Deposit object returned from API
     */
    public function Cancel($depositId, CancelDeposit $dto)
    {
        return $this->SaveObject('deposits_update', $dto, '\MangoPay\Deposit', $depositId);
    }

    /**
     * Update Deposit
     * @param string $depositId Deposit identifier
     * @param UpdateDeposit $dto Update deposit body
     * @return Deposit Deposit object returned from API
     */
    public function Update($depositId, UpdateDeposit $dto)
    {
        return $this->SaveObject('deposits_update', $dto, '\MangoPay\Deposit', $depositId);
    }

    /**
     * Get all deposits for a user
     * @param string $userId User identifier
     * @param Pagination $pagination Pagination object
     * @param FilterPreAuthorizations $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Deposit[] Deposit list returned from API
     */
    public function GetAllForUser($userId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('deposits_get_all_for_user', $pagination, '\MangoPay\Deposit', $userId, $filter, $sorting);
    }

    /**
     * Get all deposits for a user
     * @param string $cardId Card identifier
     * @param Pagination $pagination Pagination object
     * @param FilterPreAuthorizations $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Deposit[] Deposit list returned from API
     */
    public function GetAllForCard($cardId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('deposits_get_all_for_card', $pagination, '\MangoPay\Deposit', $cardId, $filter, $sorting);
    }

    /**
     * Get all transactions for a deposit
     * @param string $depositId Deposit identifier
     * @param Pagination $pagination Pagination object
     * @param FilterTransactions $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Transaction[] Transaction list returned from API
     */
    public function GetTransactions($depositId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('deposits_get_transactions', $pagination, '\MangoPay\Transaction', $depositId, $filter, $sorting);
    }
}
