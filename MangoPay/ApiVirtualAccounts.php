<?php

namespace MangoPay;

class ApiVirtualAccounts extends Libraries\ApiBase
{
    /**
     * Create new Virtual Account
     * @param String $walletId
     * @param VirtualAccount $virtualAccount
     * @return \MangoPay\VirtualAccount Virtual Account object returned from API
     */
    public function Create($virtualAccount, $walletId, $idempotencyKey = null)
    {
        return $this->CreateObject('virtual_account_create', $virtualAccount,
            '\MangoPay\VirtualAccount', $walletId, null, $idempotencyKey);
    }

    /**
     * @param string $walletId
     * @param string $virtualAccountId
     * @return \MangoPay\VirtualAccount
     */
    public function Get($walletId, $virtualAccountId)
    {
        return $this->GetObject('virtual_account_get', '\MangoPay\VirtualAccount', $walletId, $virtualAccountId);
    }

    /**
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param string $walletId
     * @return \MangoPay\VirtualAccount[]
     */
    public function GetAll($walletId, $pagination = null, $sorting = null)
    {
        return $this->GetList('virtual_account_get_all', $pagination, '\MangoPay\VirtualAccount', $walletId, $sorting);
    }

    /**
     * @param string $walletId
     * @param string $virtualAccountId
     * @return \MangoPay\VirtualAccount
     */
    public function Deactivate($walletId, $virtualAccountId)
    {
        $empty_object = new VirtualAccount();
        return $this->SaveObject('virtual_account_deactivate', $empty_object, '\MangoPay\VirtualAccount', $walletId, $virtualAccountId);
    }

    /**
     * @return \MangoPay\VirtualAccountAvailabilities
     */
    public function GetAvailabilities()
    {
        return $this->GetObject('virtual_account_get_availabilities', '\MangoPay\VirtualAccountAvailabilities');
    }
}
