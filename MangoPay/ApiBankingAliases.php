<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for Banking Aliases
 */
class ApiBankingAliases extends Libraries\ApiBase
{
    /**
     * Get a banking alias
     * @param string $bankingAliasId Banking alias identifier
     * @return \MangoPay\BankingAlias returned from API
     */
    public function Get($bankingAliasId)
    {
        $response = $this->GetObject('banking_aliases_get', null, $bankingAliasId);
        return $this->GetBankingAliasResponse($response);
    }

    /**
     * Create a banking alias
     * @param \MangoPay\BankingAlias $bankingAlias Banking alias
     * @return \MangoPay\BankingAlias returned from API
     * @throws Libraries\Exception
     */
    public function Create($bankingAlias, $idempotencyKey = null)
    {
        $className = get_class($bankingAlias);
        if ($className == 'MangoPay\BankingAliasIBAN') {
            $methodKey = 'banking_aliases_iban_create';
        } else {
            throw new Libraries\Exception('Wrong entity class for BankingAlias');
        }

        $response = $this->CreateObject($methodKey, $bankingAlias, null, $bankingAlias->WalletId,
            null, $idempotencyKey);
        return $this->GetBankingAliasResponse($response);
    }

    /**
     * Update banking alias
     * @param \MangoPay\BankingAlias $bankingAlias Card object to save
     * @return \MangoPay\BankingAlias Card object returned from API
     */
    public function Update($bankingAlias)
    {
        $response = $this->SaveObject('banking_aliases_update', $bankingAlias);
        return $this->GetBankingAliasResponse($response);
    }

    /**
     * Get all banking aliases
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param string $walletId Wallet identifier
     * @return \MangoPay\BankingAlias[] List of banking aliases
     */
    public function GetAll($walletId, &$pagination = null, $sorting = null)
    {
        $bankingAliases = $this->GetList('banking_aliases_all', $pagination, null, $walletId, null, $sorting);
        return array_map([$this, "GetBankingAliasResponse"], $bankingAliases);
    }

    /**
     * Get correct banking alias object
     * @param object $response Response from API
     * @return \MangoPay\BankingAlias BankingAlias object returned from API
     * @throws \MangoPay\Libraries\Exception If occur unexpected response from API
     */
    private function GetBankingAliasResponse($response)
    {
        if (isset($response->Type)) {
            switch ($response->Type) {
                case BankingAliasType::GB:
                case BankingAliasType::IBAN:
                    return $this->CastResponseToEntity($response, '\MangoPay\BankingAliasIBAN');
                default:
                    throw new Libraries\Exception('Unexpected response. Wrong BankingAlias Type value');
            }
        } else {
            throw new Libraries\Exception('Unexpected response. Missing BankingAlias Type property');
        }
    }
}
