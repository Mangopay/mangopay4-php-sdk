<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for refunds
 */
class ApiRefunds extends Libraries\ApiBase
{
    /**
     * Get refund object
     * @param string $refundId Refund Id
     * @return Refund Refund object returned from API
     */
    public function Get($refundId)
    {
        return $this->GetObject('refunds_get', '\MangoPay\Refund', $refundId);
    }
}
