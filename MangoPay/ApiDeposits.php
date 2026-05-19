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
        return $this->CreateObject(
            'deposits_create',
            $deposit,
            '\MangoPay\Deposit',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Create PayPal Deposit Preauthorization
     * @param PayPalDepositPreauthorization $deposit Deposit object to save
     * @return PayPalDepositPreauthorization Deposit object returned from API
     */
    public function CreatePayPalDepositPreauthorization(PayPalDepositPreauthorization $deposit, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'deposits_create_paypal',
            $deposit,
            '\MangoPay\PayPalDepositPreauthorization',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Get Deposit. Returns a PayPalDepositPreauthorization instance when the
     * underlying deposit was created via PayPal, otherwise a Deposit instance.
     * @param string $depositId Deposit identifier
     * @return Deposit|PayPalDepositPreauthorization Deposit object returned from API
     */
    public function Get($depositId)
    {
        $response = $this->GetObject('deposits_get', null, $depositId);
        return $this->CastResponseToEntity($response, $this->ResolveDepositClass($response));
    }

    /**
     * Cancel Deposit. Returns a PayPalDepositPreauthorization instance when the
     * underlying deposit was created via PayPal, otherwise a Deposit instance.
     * @param string $depositId Deposit identifier
     * @param CancelDeposit $dto Cancel deposit body
     * @return Deposit|PayPalDepositPreauthorization Deposit object returned from API
     */
    public function Cancel($depositId, CancelDeposit $dto)
    {
        $response = $this->SaveObject('deposits_update', $dto, null, $depositId);
        return $this->CastResponseToEntity($response, $this->ResolveDepositClass($response));
    }

    /**
     * Update Deposit. Returns a PayPalDepositPreauthorization instance when the
     * underlying deposit was created via PayPal, otherwise a Deposit instance.
     * @param string $depositId Deposit identifier
     * @param UpdateDeposit $dto Update deposit body
     * @return Deposit|PayPalDepositPreauthorization Deposit object returned from API
     */
    public function Update($depositId, UpdateDeposit $dto)
    {
        $response = $this->SaveObject('deposits_update', $dto, null, $depositId);
        return $this->CastResponseToEntity($response, $this->ResolveDepositClass($response));
    }

    /**
     * Get all deposits for a user. PayPal items are returned as
     * PayPalDepositPreauthorization instances; others as Deposit.
     * @param string $userId User identifier
     * @param Pagination $pagination Pagination object
     * @param FilterPreAuthorizations $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Deposit[]|PayPalDepositPreauthorization[] Deposit list returned from API
     */
    public function GetAllForUser($userId, $pagination = null, $filter = null, $sorting = null)
    {
        $response = $this->GetList('deposits_get_all_for_user', $pagination, null, $userId, $filter, $sorting);
        $list = [];
        if (is_array($response)) {
            foreach ($response as $item) {
                $list[] = $this->CastResponseToEntity($item, $this->ResolveDepositClass($item));
            }
        }
        return $list;
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

    private function ResolveDepositClass($rawResponse)
    {
        if (is_object($rawResponse)
            && isset($rawResponse->PaymentType)
            && $rawResponse->PaymentType === PayInPaymentType::PayPal) {
            return '\MangoPay\PayPalDepositPreauthorization';
        }
        return '\MangoPay\Deposit';
    }
}
