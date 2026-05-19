<?php

namespace MangoPay;

class ApiAcquiring extends Libraries\ApiBase
{
    /**
     * Create new pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function CreatePayIn($payIn, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject(
            'acquiring_payins_' . $paymentKey . '-' . $executionKey . '_create',
            $payIn,
            '\MangoPay\PayIn',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Send key pre-transaction data such as order details, buyer information,
     * and merchant context before initiating a PayPal payment
     *
     * Since the fields needed by PayPal are dynamic and can change, the method expects a stdClass as payload
     *
     * @param \stdClass $dataCollection
     * @param string $idempotencyKey
     * @return \stdClass
     */
    public function CreatePayPalDataCollection($dataCollection, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'acquiring_payins_paypal_data_collection_create',
            $dataCollection,
            null,
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Create refund for pay-in object
     * @param string $payInId Pay-in identifier
     * @param \MangoPay\Refund $refund Refund object to create
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function CreatePayInRefund($payInId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'acquiring_payins_createrefunds',
            $refund,
            '\MangoPay\Refund',
            $payInId,
            null,
            $idempotencyKey
        );
    }

    /**
     * Create a card validation
     * @param $cardId
     * @return \MangoPay\CardValidation
     * @throws Libraries\Exception
     */
    public function CreateCardValidation($cardId, $cardValidation, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'acquiring_card_validate',
            $cardValidation,
            '\MangoPay\CardValidation',
            $cardId,
            null,
            $idempotencyKey
        );
    }

    private function GetPaymentKey($payIn)
    {
        if (!isset($payIn->PaymentDetails) || !is_object($payIn->PaymentDetails)) {
            throw new Libraries\Exception('PaymentDetails is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\PayInPaymentDetails', '', get_class($payIn->PaymentDetails));
        return strtolower($className);
    }

    private function GetExecutionKey($payIn)
    {
        if (!isset($payIn->ExecutionDetails) || !is_object($payIn->ExecutionDetails)) {
            throw new Libraries\Exception('ExecutionDetails is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\PayInExecutionDetails', '', get_class($payIn->ExecutionDetails));
        return strtolower($className);
    }
}
