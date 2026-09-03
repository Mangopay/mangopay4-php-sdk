<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for wallets
 */
class ApiWallets extends Libraries\ApiBase
{
    /**
     * Create new wallet
     * @param Wallet $wallet
     * @return Wallet Wallet object returned from API
     */
    public function Create($wallet, $idempotencyKey = null)
    {
        return $this->CreateObject('wallets_create', $wallet, '\MangoPay\Wallet', null, null, $idempotencyKey);
    }

    /**
     * Get wallet
     * @param string $walletId Wallet identifier
     * @param string $scaContext Optional. Possible values: USER_NOT_PRESENT, USER_PRESENT
     * In case USER_PRESENT is used and SCA is required, an error containing the RedirectUrl will be thrown
     * @return Wallet Wallet object returned from API
     */
    public function Get($walletId, $scaContext = null)
    {
        if ($scaContext != null) {
            return $this->GetObject('wallets_get_sca', '\MangoPay\Wallet', $walletId, $scaContext);
        }
        return $this->GetObject('wallets_get', '\MangoPay\Wallet', $walletId);
    }

    /**
     * Save wallet
     * @param Wallet $wallet Wallet object to save
     * @return Wallet Wallet object returned from API
     */
    public function Update($wallet)
    {
        return $this->SaveObject('wallets_save', $wallet, '\MangoPay\Wallet');
    }

    /**
     * Get transactions for the wallet
     * @param string $walletId Wallet identifier
     * @param Pagination $pagination Pagination object
     * @param FilterTransactions $filter Object to filter data
     * @param Sorting $sorting Object to sorting data
     * @return Transaction[] Transactions for wallet returned from API
     */
    public function GetTransactions($walletId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('wallets_alltransactions', $pagination, '\MangoPay\Transaction', $walletId, $filter, $sorting);
    }
}
