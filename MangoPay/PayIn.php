<?php

namespace MangoPay;

/**
 * Pay-in entity
 */
class PayIn extends Transaction
{
    /**
     * Credited wallet Id
     * @var string
     */
    public $CreditedWalletId;

    /**
     * PaymentType {CARD, BANK_WIRE, DIRECT_DEBIT, PAYPAL, PAYCONIQ }
     * @var string
     */
    public $PaymentType;

    /**
     * One of PayInPaymentDetails implementations, depending on $PaymentType
     * @var object
     */
    public $PaymentDetails;

    /**
     * ExecutionType { WEB, TOKEN, DIRECT, PREAUTHORIZED, RECURRING_ORDER_EXECUTION }
     * @var string
     */
    public $ExecutionType;

    /**
     * One of PayInExecutionDetails implementations, depending on $ExecutionType
     * @var object
     */
    public $ExecutionDetails;

    /**
     * Recurring PayIn Registration Id
     * @var string
     */
    public $RecurringPayinRegistrationId;

    /**
     * Allowed values: ECommerce (default), TelephoneOrder
     *
     * The channel through which the user provided their card details, used to indicate mail-order and telephone-order (MOTO) payments.
     * @var string
     */
    public $PaymentCategory;

    /**
     * The unique reference generated for the profiling session,
     * used by the fraud prevention solution to produce recommendations for the transaction using the profiling data
     * @var string
     */
    public $ProfilingAttemptReference;

    /**
     * Authentication result. Returned on Card related transactions.
     * @var AuthenticationResult|null
     */
    public $AuthenticationResult;

    /**
     * Get array with mapping which property depends on other property
     * @return array
     */
    public function GetDependsObjects()
    {
        return [
            'PaymentType' => [
                '_property_name' => 'PaymentDetails',
                PayInPaymentType::Card => '\MangoPay\PayInPaymentDetailsCard',
                PayInPaymentType::Preauthorized => '\MangoPay\PayInPaymentDetailsPreAuthorized',
                PayInPaymentType::BankWire => '\MangoPay\PayInPaymentDetailsBankWire',
                PayInPaymentType::DirectDebit => '\MangoPay\PayInPaymentDetailsDirectDebit',
                PayInPaymentType::DirectDebitDirect => '\MangoPay\PayInPaymentDetailsDirectDebitDirect',
                PayInPaymentType::PayPal => '\MangoPay\PayInPaymentDetailsPaypal',
                PayInPaymentType::ApplePay => 'MangoPay\PayInPaymentDetailsApplePay',
                PayInPaymentType::GooglePay => 'MangoPay\PayInPaymentDetailsGooglePay',
                PayInPaymentType::GooglePayV2 => 'MangoPay\PayInPaymentDetailsGooglePay',
                PayInPaymentType::Payconiq => 'MangoPay\PayInPaymentDetailsPayconiq',
                PayInPaymentType::Mbway => 'MangoPay\PayInPaymentDetailsMbway',
                PayInPaymentType::Multibanco => 'MangoPay\PayInPaymentDetailsMultibanco',
                PayInPaymentType::Satispay => 'MangoPay\PayInPaymentDetailsSatispay',
                PayInPaymentType::Blik => 'MangoPay\PayInPaymentDetailsBlik',
                PayInPaymentType::Klarna => 'MangoPay\PayInPaymentDetailsKlarna',
                PayInPaymentType::Ideal => 'MangoPay\PayInPaymentDetailsIdeal',
                PayInPaymentType::Giropay => 'MangoPay\PayInPaymentDetailsGiropay',
                PayInPaymentType::Bancontact => 'MangoPay\PayInPaymentDetailsBancontact',
                PayInPaymentType::Bizum => 'MangoPay\PayInPaymentDetailsBizum',
                PayInPaymentType::Swish => 'MangoPay\PayInPaymentDetailsSwish',
                PayInPaymentType::Twint => 'MangoPay\PayInPaymentDetailsTwint',
                PayInPaymentType::PayByBank => 'MangoPay\PayInPaymentDetailsPayByBank',
                // ...and more in future...
            ],
            'ExecutionType' => [
                '_property_name' => 'ExecutionDetails',
                PayInExecutionType::Web => '\MangoPay\PayInExecutionDetailsWeb',
                PayInExecutionType::Direct => '\MangoPay\PayInExecutionDetailsDirect',
                PayInExecutionType::ExternalInstruction => '\MangoPay\PayInExecutionDetailsExternalInstruction',
                // ...and more in future...
            ]
        ];
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'PaymentType');
        array_push($properties, 'ExecutionType');

        return $properties;
    }
}
