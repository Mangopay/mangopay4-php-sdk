<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API for bank accounts
 */
class ApiBankAccounts extends Libraries\ApiBase
{
    /**
     * Retrieves a list of Transactions pertaining to a certain Bank Account
     * @param string $bankAccountId Bank Account identifier
     * @param Pagination $pagination Pagination object
     * @param FilterTransactions $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @throws Libraries\Exception
     */
    public function GetTransactions($bankAccountId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('transactions_get_for_bank_account', $pagination, '\MangoPay\Transaction', $bankAccountId, $filter, $sorting);
    }
}
