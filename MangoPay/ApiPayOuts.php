<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for pay-outs
 */
class ApiPayOuts extends Libraries\ApiBase
{
    /**
     * Create new pay-out
     * @param PayOut $payOut
     * @return PayOut Object returned from API
     */
    public function Create($payOut, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payOut);
        return $this->CreateObject('payouts_' . $paymentKey . '_create', $payOut, '\MangoPay\PayOut', null, null, $idempotencyKey);
    }

    /**
     * This method is used to check whether or not the destination bank is eligible for instant payout.
     * @param PayOutEligibilityRequest $payOutEligibility
     * @param $idempotencyKey
     * @return PayOutEligibilityResponse Object returned for the API
     */
    public function CheckInstantPayoutEligibility($payOutEligibility, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payouts_check_eligibility',
            $payOutEligibility,
            '\MangoPay\PayOutEligibilityResponse',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Get pay-out object
     * @param string $payOutId PayOut identifier
     * @return PayOut Object returned from API
     */
    public function Get($payOutId)
    {
        return $this->GetObject('payouts_get', '\MangoPay\PayOut', $payOutId);
    }

    /**
     * Get bankwire pay-out object
     * @param string $payOutId PayOut identifier
     * @return PayOut Object returned from API
     * @throws Libraries\Exception
     */
    public function GetBankwire($payOutId)
    {
        return $this->GetObject('payouts_bankwire_get', '\MangoPay\PayOut', $payOutId);
    }

    /**
     * Returns a list of Refunds pertaining to a certain PayOut.
     * @param string $payOutId ID of the PayOut for which to retrieve Refunds
     * @param Pagination $pagination Pagination object
     * @param FilterRefunds $filter Filtering object
     * @param Sorting $sorting Sorting object
     * @return Refund[] List of Refunds for the PayOut
     */
    public function GetRefunds($payOutId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('refunds_get_for_payout', $pagination, '\MangoPay\Refund', $payOutId, $filter, $sorting);
    }

    private function GetPaymentKey($payOut)
    {
        if (!isset($payOut->MeanOfPaymentDetails) || !is_object($payOut->MeanOfPaymentDetails)) {
            throw new Libraries\Exception('Mean of payment is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\PayOutPaymentDetails', '', get_class($payOut->MeanOfPaymentDetails));
        return strtolower($className);
    }
}
