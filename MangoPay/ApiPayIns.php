<?php

namespace MangoPay;

use MangoPay\Libraries\Exception;

/**
 * Class to management MangoPay API for pay-ins
 */
class ApiPayIns extends Libraries\ApiBase
{
    /**
     * Create new pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Create($payIn, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('payins_' . $paymentKey . '-' . $executionKey . '_create', $payIn,
            '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Get pay-in object
     * @param string $payInId Pay-in identifier
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Get($payInId)
    {
        return $this->GetObject('payins_get', '\MangoPay\PayIn', $payInId);
    }

    /**
     * Create refund for pay-in object
     * @param string $payInId Pay-in identifier
     * @param \MangoPay\Refund $refund Refund object to create
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function CreateRefund($payInId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_createrefunds', $refund,
            '\MangoPay\Refund', $payInId, null, $idempotencyKey);
    }

    /**
     * Create a recurring payment
     * @param \MangoPay\PayInRecurringRegistration $recurringRegistration
     * @return \MangoPay\PayInRecurringRegistrationRequestResponse
     */
    public function CreateRecurringRegistration($recurringRegistration, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_registration', $recurringRegistration,
            '\MangoPay\PayInRecurringRegistrationRequestResponse', null, null, $idempotencyKey);
    }

    /**
     * Get recurring payment
     * @param string $recurringRegistrationId
     * @return \MangoPay\PayInRecurringRegistrationGet
     */
    public function GetRecurringRegistration($recurringRegistrationId, $idempotencyKey = null)
    {
        return $this->GetObject('payins_recurring_registration_get', '\MangoPay\PayInRecurringRegistrationGet', $recurringRegistrationId);
    }

    /**
    * Update recurring payment
    * @param PayInRecurringRegistrationUpdate $recurringUpdate
    * @return \MangoPay\PayInRecurringRegistrationGet
    */
    public function UpdateRecurringRegistration($recurringUpdate, $idempotencyKey = null)
    {
        return $this->SaveObject('payins_recurring_registration_put', $recurringUpdate, '\MangoPay\PayInRecurringRegistrationGet');
    }

    /**
     * Create a Recurring PayIn CIT
     * @param \MangoPay\RecurringPayInCIT $recurringPayInRegistrationCIT
     * @return \MangoPay\PayInRecurring
     */
    public function CreateRecurringPayInRegistrationCIT($recurringPayInRegistrationCIT, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_card_direct', $recurringPayInRegistrationCIT,
            '\MangoPay\PayInRecurring', null, null, $idempotencyKey);
    }

    /**
     * Create a Recurring PayIn MIT
     * @param \MangoPay\RecurringPayInMIT $recurringPayInRegistrationMIT
     * @return \MangoPay\PayInRecurring
     */
    public function CreateRecurringPayInRegistrationMIT($recurringPayInRegistrationMIT, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_card_direct', $recurringPayInRegistrationMIT,
            '\MangoPay\PayInRecurring', null, null, $idempotencyKey);
    }

    /**
     * Create a Recurring PayPal PayIn CIT
     * @param \MangoPay\RecurringPayPalPayInCIT $recurringPayPalPayInCIT
     * @return \MangoPay\PayInRecurring
     */
    public function CreateRecurringPayPalPayInCIT($recurringPayPalPayInCIT, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_paypal', $recurringPayPalPayInCIT,
            '\MangoPay\PayInRecurring', null, null, $idempotencyKey);
    }

    /**
     * Create a Recurring PayPal PayIn MIT
     * @param \MangoPay\RecurringPayPalPayInMIT $recurringPayPalPayInMIT
     * @return \MangoPay\PayInRecurring
     */
    public function CreateRecurringPayPalPayInMIT($recurringPayPalPayInMIT, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_paypal', $recurringPayPalPayInMIT,
            '\MangoPay\PayInRecurring', null, null, $idempotencyKey);
    }

    /**
     * Retrieves a list of Refunds pertaining to a certain PayIn
     * @param string $payInId ID of PayIn for which to retrieve Refunds
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterRefunds $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\Refund[] List of the PayIn's Refunds
     */
    public function GetRefunds($payInId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('refunds_get_for_payin', $pagination, '\MangoPay\Refund', $payInId, $filter, $sorting);
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

    /**
     * Retrieves a more detailed view of details concerning
     * the card used to process a Web payment.
     * @param string $payInId ID of the PayIn to retrieve card details for
     * @return \MangoPay\PayInWebExtendedView Object returned from API
     */
    public function GetExtendedCardView($payInId)
    {
        return $this->GetObject('get_extended_card_view', '\MangoPay\PayInWebExtendedView', $payInId);
    }

    /**
     * Create Card PreAuthorized Deposit PayIn
     * @param CreateCardPreAuthorizedDepositPayIn $payIn PayIn object to create
     * @return PayIn Deposit object returned from API
     */
    public function CreateCardPreAuthorizedDepositPayIn(CreateCardPreAuthorizedDepositPayIn $payIn)
    {
        return $this->CreateObject('payins_create_card_pre_authorized_deposit', $payIn, '\MangoPay\PayIn');
    }

    /**
     * Create a Deposit Preauthorized PayIn without complement
     * @param CreateCardPreAuthorizedDepositPayIn $payIn PayIn object to create
     * @param string $idempotencyKey Optional idempotency key
     * @return PayIn Deposit object returned from API
     */
    public function CreateDepositPreauthorizedPayInWithoutComplement(CreateCardPreAuthorizedDepositPayIn $payIn, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_create_card_pre_authorized_deposit', $payIn,
            '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Create a Deposit Preauthorized PayIn prior to complement
     * @param CreateCardPreAuthorizedDepositPayIn $payIn PayIn object to create
     * @return PayIn Deposit object returned from API
     */
    public function CreateDepositPreauthorizedPayInPriorToComplement(CreateCardPreAuthorizedDepositPayIn $payIn, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_deposit_preauthorized_prior_to_complement', $payIn,
            '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Create a Deposit Preauthorized PayIn complement
     * @param CreateCardPreAuthorizedDepositPayIn $payIn PayIn object to create
     * @return PayIn Deposit object returned from API
     */
    public function CreateDepositPreauthorizedPayInComplement(CreateCardPreAuthorizedDepositPayIn $payIn, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_deposit_preauthorized_complement', $payIn,
            '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Create new PayPal Web pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function CreatePayPal($payIn, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_paypal-web_create_v2', $payIn, '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Create new GooglePay Direct pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function CreateGooglePay($payIn, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_googlepay-direct_create_v2', $payIn, '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Look up metadata from BIN or Google Pay token
     * @param \MangoPay\PaymentMethodMetadata $paymentMethodMetadata \MangoPay\PaymentMethodMetadata object
     * @return \MangoPay\PaymentMethodMetadata Object returned from API
     */
    public function GetPaymentMethodMetadata(PaymentMethodMetadata $paymentMethodMetadata, $idempotencyKey = null)
    {
        return $this->CreateObject('payment_method-metadata', $paymentMethodMetadata, '\MangoPay\PaymentMethodMetadata', null, null, $idempotencyKey);
    }

    public function AddPayPalTrackingInformation($payId, PayPalWebTracking $palWebTracking)
    {
        return $this->SaveObject('add_tracking_info', $palWebTracking, '\MangoPay\PayIn', $payId);
    }

    /**
     * Create a Payconiq Web PayIn using the latest API url (payins/payment-methods/payconiq)
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function CreatePayconiq($payIn, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_payconiqv2-web_create', $payIn, '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Create a pay in intent authorization
     * @param \MangoPay\PayInIntent $payInIntentAuthorization \MangoPay\PayInIntent object
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function CreatePayInIntentAuthorization($payInIntentAuthorization, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_create_authprization',
            $payInIntentAuthorization,
            '\MangoPay\PayInIntent',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Create a pay in intent authorization
     * @param string $intentId The identifier of the PayInIntent
     * @param \MangoPay\PayInIntent $payInIntentCapture \MangoPay\PayInIntent object
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function CreatePayInIntentCapture($intentId, $payInIntentCapture, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_create_capture',
            $payInIntentCapture,
            '\MangoPay\PayInIntent',
            $intentId,
            null,
            $idempotencyKey
        );
    }

    /**
     * Get a pay in intent
     * @param string $intentId The identifier of the PayInIntent
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function GetPayInIntent($intentId)
    {
        return $this->GetObject('payins_intent_get', '\MangoPay\PayInIntent', $intentId);
    }

    /**
     * Cancel a pay in intent
     * @param string $intentId The identifier of the PayInIntent
     * @param PayInIntent $details Intent details
     * @param string|null $idempotencyKey Idempotency key for this request (optional)
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function CancelPayInIntent($intentId, $details, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_cancel',
            $details,
            '\MangoPay\PayInIntent',
            $intentId,
            null,
            $idempotencyKey
        );
    }

    /**
     * Create Intent splits
     * @param string $intentId The identifier of the PayInIntent
     * @param IntentSplits $splits Splits
     * @return \MangoPay\IntentSplits Object returned from API
     */
    public function CreatePayInIntentSplits($intentId, $splits, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_create_splits',
            $splits,
            '\MangoPay\IntentSplits',
            $intentId,
            null,
            $idempotencyKey
        );
    }

    /**
     * Execute split
     * @param string $intentId The identifier of the PayInIntent
     * @param string $splitId The identifier of the Split
     * @return PayInIntentSplit Object returned from API
     */
    public function ExecutePayInIntentSplit($intentId, $splitId, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_execute_split',
            null,
            '\MangoPay\PayInIntentSplit',
            $intentId,
            $splitId,
            $idempotencyKey
        );
    }

    /**
     * Reverse split
     * @param string $intentId The identifier of the PayInIntent
     * @param string $splitId The identifier of the Split
     * @return PayInIntentSplit Object returned from API
     */
    public function ReversePayInIntentSplit($intentId, $splitId, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_reverse_split',
            null,
            '\MangoPay\PayInIntentSplit',
            $intentId,
            $splitId,
            $idempotencyKey
        );
    }

    /**
     * Get split
     * @param string $intentId The identifier of the PayInIntent
     * @param string $splitId The identifier of the Split
     * @return PayInIntentSplit Object returned from API
     */
    public function GetPayInIntentSplit($intentId, $splitId)
    {
        return $this->GetObject(
            'payins_intent_get_split',
            '\MangoPay\PayInIntentSplit',
            $intentId,
            $splitId
        );
    }

    /**
     * Execute split
     * @param string $intentId The identifier of the PayInIntent
     * @param PayInIntentSplit $split Object containing the properties to be updated.
     * At least the 'Id' and 'LineItemId' need to be present.
     * @return PayInIntentSplit Object returned from API
     */
    public function UpdatePayInIntentSplit($intentId, $split)
    {
        return $this->SaveObject(
            'payins_intent_update_split',
            $split,
            '\MangoPay\PayInIntentSplit',
            $intentId
        );
    }

    /**
     * Create a pay in intent refund (full or partial)
     * @param string $intentId The identifier of the PayInIntent
     * @param \MangoPay\PayInIntent $payInIntentRefund The Refund to be created
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function CreatePayInIntentRefund($intentId, $payInIntentRefund, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_create_refund',
            $payInIntentRefund,
            '\MangoPay\PayInIntent',
            $intentId,
            null,
            $idempotencyKey
        );
    }

    /**
     * Reverse a pay in intent refund (fully or partial)
     * @param string $intentId The identifier of the PayInIntent
     * @param string $refundId The identifier of the PayInIntentRefund
     * @param \MangoPay\PayInIntent $payInIntentRefund The Refund to be reversed
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function ReversePayInIntentRefund($intentId, $refundId, $payInIntentRefund, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_reverse_refund',
            $payInIntentRefund,
            '\MangoPay\PayInIntent',
            $intentId,
            $refundId,
            $idempotencyKey
        );
    }

    /**
     * Retrieve a paginated list of banks that you can present to the user for selection during their Pay by Bank checkout experience
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterSupportedBanks $filter Filtering object
     * @return \MangoPay\PayByBankSupportedBank Object returned by the API
     */
    public function GetPayByBankSupportedBanks($pagination = null, $filter = null)
    {
        return $this->GetObjectWithPagination(
            'pay_by_bank_get_supported_banks',
            '\MangoPay\PayByBankSupportedBank',
            $pagination,
            $filter
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
        return $this->CreateObject('payins_paypal_data_collection_create', $dataCollection, null, null, null, $idempotencyKey);
    }

    /**
     * Send key pre-transaction data such as order details, buyer information,
     * and merchant context before initiating a PayPal payment
     *
     * @param string $dataCollectionId
     * @return \stdClass
     * @throws Exception
     */
    public function GetPayPalDataCollection($dataCollectionId, $idempotencyKey = null)
    {
        return $this->GetObject('payins_paypal_data_collection_get', null, $dataCollectionId);
    }

    /**
     * Create a PayInIntentDispute (full or partial)
     * @param string $intentId The identifier of the PayInIntent
     * @param string $captureId The identifier of the PayInIntentCapture
     * @param \MangoPay\PayInIntent $payInIntentDispute The Dispute to be created
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function CreatePayInIntentDispute($intentId, $captureId, $payInIntentDispute, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'payins_intent_create_dispute',
            $payInIntentDispute,
            '\MangoPay\PayInIntent',
            $intentId,
            $captureId,
            $idempotencyKey
        );
    }

    /**
     * Update PayInIntentDispute outcome
     * @param string $intentId The identifier of the PayInIntent
     * @param string $captureId The identifier of the PayInIntentCapture
     * @param string $disputeId The identifier of the PayInIntentDispute
     * @param \MangoPay\PayInIntent $disputeOutcome Object containing the 'decision' and intent id
     * @return \MangoPay\PayInIntent Object returned from API
     */
    public function UpdatePayInIntentDisputeOutcome($intentId, $captureId, $disputeId, $disputeOutcome)
    {
        return $this->UpdateObject(
            'payins_intent_update_dispute_outcome',
            $disputeOutcome,
            '\MangoPay\PayInIntent',
            $intentId,
            $captureId,
            $disputeId
        );
    }
}
