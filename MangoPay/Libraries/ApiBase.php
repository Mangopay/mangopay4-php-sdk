<?php

namespace MangoPay\Libraries;

/**
 * Base class for MangoPay API managers
 */
abstract class ApiBase
{
    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    protected $_root;

    /**
     * @return mixed
     */
    protected function getLogger()
    {
        return $this->_root->getLogger();
    }

    /**
     * Array with REST url and request type
     * @var array
     */
    private $_methods = [
        'authentication_base' => ['/clients/', RequestType::POST],
        'authentication_oauth' => ['/oauth/token/', RequestType::POST],

        'responses_get' => ['/responses/%s', RequestType::GET],

        'events_all' => ['/events', RequestType::GET],

        'hooks_create' => ['/hooks', RequestType::POST],
        'hooks_all' => ['/hooks', RequestType::GET],
        'hooks_get' => ['/hooks/%s', RequestType::GET],
        'hooks_save' => ['/hooks/%s', RequestType::PUT],

        'cardregistration_create' => ['/cardregistrations', RequestType::POST],
        'cardregistration_get' => ['/cardregistrations/%s', RequestType::GET],
        'cardregistration_save' => ['/cardregistrations/%s', RequestType::PUT],

        'preauthorization_create' => ['/preauthorizations/card/direct', RequestType::POST],
        'preauthorization_get' => ['/preauthorizations/%s', RequestType::GET],
        'preauthorizations_get_for_card' => ['/cards/%s/preauthorizations', RequestType::GET],
        'preauthorizations_get_for_user' => ['/users/%s/preauthorizations', RequestType::GET],
        'preauthorization_save' => ['/preauthorizations/%s', RequestType::PUT],
        'preauthorization_transactions_get' => ['/preauthorizations/%s/transactions', RequestType::GET],

        'card_get' => ['/cards/%s', RequestType::GET],
        'cards_get_by_fingerprint' => ['/cards/fingerprints/%s', RequestType::GET],
        'card_save' => ['/cards/%s', RequestType::PUT],
        'card_validate' => ['/cards/%s/validation', RequestType::POST],
        'get_card_validation' => ['/cards/%s/validation/%s', RequestType::GET],
        'transactions_get_by_fingerprint' => ['/cards/fingerprints/%s/transactions', RequestType::GET],

        // pay ins URLs
        'payins_card-web_create' => ['/payins/card/web/', RequestType::POST],
        'payins_card-direct_create' => ['/payins/card/direct/', RequestType::POST],
        'payins_preauthorized-direct_create' => ['/payins/preauthorized/direct/', RequestType::POST],
        'payins_bankwire-direct_create' => ['/payins/bankwire/direct/', RequestType::POST],
        'payins_directdebit-web_create' => ['/payins/directdebit/web', RequestType::POST],
        'payins_directdebit-direct_create' => ['/payins/directdebit/direct', RequestType::POST],
        'payins_directdebitdirect-direct_create' => ['/payins/directdebit/direct', RequestType::POST],
        'payins_paypal-web_create' => ['/payins/paypal/web', RequestType::POST],
        'payins_paypal-web_create_v2' => ['/payins/payment-methods/paypal', RequestType::POST],
        'payins_paypal_data_collection_create' => ['/payins/payment-methods/paypal/data-collection', RequestType::POST],
        'payins_paypal_data_collection_get' => ['/payins/payment-methods/paypal/data-collection/%s', RequestType::GET],
        'payins_payconiq-web_create' => ['/payins/payconiq/web', RequestType::POST],
        'payins_payconiqv2-web_create' => ['/payins/payment-methods/payconiq', RequestType::POST],
        'payins_get' => ['/payins/%s', RequestType::GET],
        'payins_createrefunds' => ['/payins/%s/refunds', RequestType::POST],
        'payins_applepay-direct_create' => ['/payins/applepay/direct', RequestType::POST],
        'payins_googlepay-direct_create' => ['/payins/googlepay/direct', RequestType::POST],
        'payins_googlepay-direct_create_v2' => ['/payins/payment-methods/googlepay', RequestType::POST],
        'payins_mbway-web_create' => ['/payins/payment-methods/mbway', RequestType::POST],
        'payins_multibanco-web_create' => ['/payins/payment-methods/multibanco', RequestType::POST],
        'payins_satispay-web_create' => ['/payins/payment-methods/satispay', RequestType::POST],
        'payins_blik-web_create' => ['/payins/payment-methods/blik', RequestType::POST],
        'payins_klarna-web_create' => ['/payins/payment-methods/klarna', RequestType::POST],
        'payins_ideal-web_create' => ['/payins/payment-methods/ideal', RequestType::POST],
        'payins_giropay-web_create' => ['/payins/payment-methods/giropay', RequestType::POST],
        'payins_bancontact-web_create' => ['/payins/payment-methods/bancontact', RequestType::POST],
        'payins_bizum-web_create' => ['/payins/payment-methods/bizum', RequestType::POST],
        'payins_swish-web_create' => ['/payins/payment-methods/swish', RequestType::POST],
        'payins_twint-web_create' => ['/payins/payment-methods/twint', RequestType::POST],
        'payins_paybybank-web_create' => ['/payins/payment-methods/openbanking', RequestType::POST],
        'add_tracking_info' => ['/payins/%s/trackings', RequestType::PUT],

        'payment_method-metadata' => ['/payment-methods/metadata', RequestType::POST],

        'payins_recurring_registration' => ['/recurringpayinregistrations', RequestType::POST],
        'payins_recurring_registration_get' => ['/recurringpayinregistrations/%s', RequestType::GET],
        'payins_recurring_registration_put' => ['/recurringpayinregistrations/%s', RequestType::PUT],
        'payins_recurring_card_direct' => ['/payins/recurring/card/direct', RequestType::POST],
        'payins_recurring_paypal' => ['/payins/payment-methods/paypal/recurring', RequestType::POST],
        'payins_create_card_pre_authorized_deposit' => ['/payins/deposit-preauthorized/direct/full-capture', RequestType::POST],
        'payins_deposit_preauthorized_prior_to_complement' => ['/payins/deposit-preauthorized/direct/capture-with-complement', RequestType::POST],
        'payins_deposit_preauthorized_complement' => ['/payins/deposit-preauthorized/direct/complement', RequestType::POST],

        'payins_intent_create_authprization' => ['/payins/intents', RequestType::POST, 'V3.0'],
        'payins_intent_create_capture' => ['/payins/intents/%s/captures', RequestType::POST, 'V3.0'],
        'payins_intent_get' => ['/payins/intents/%s', RequestType::GET, 'V3.0'],
        'payins_intent_cancel' => ['/payins/intents/%s/cancel', RequestType::POST, 'V3.0'],
        'payins_intent_create_splits' => ['/payins/intents/%s/splits', RequestType::POST, 'V3.0'],
        'settlement_generate_upload_url' => ['/payins/intents/settlements', RequestType::POST, 'V3.0'],
        'settlement_get' => ['/payins/intents/settlements/%s', RequestType::GET, 'V3.0'],
        'settlement_generate_new_upload_url' => ['/payins/intents/settlements/%s', RequestType::PUT, 'V3.0'],
        'payins_intent_execute_split' => ['/payins/intents/%s/splits/%s/execute', RequestType::POST, 'V3.0'],
        'payins_intent_reverse_split' => ['/payins/intents/%s/splits/%s/reverse', RequestType::POST, 'V3.0'],
        'payins_intent_get_split' => ['/payins/intents/%s/splits/%s', RequestType::GET, 'V3.0'],
        'payins_intent_update_split' => ['/payins/intents/%s/splits/%s', RequestType::PUT, 'V3.0'],

        'repudiation_get' => ['/repudiations/%s', RequestType::GET],

        'get_extended_card_view' => ['/payins/card/web/%s/extended', RequestType::GET],

        'payouts_bankwire_create' => ['/payouts/bankwire/', RequestType::POST],
        'payouts_bankwire_get' => ['/payouts/bankwire/%s', RequestType::GET],
        'payouts_get' => ['/payouts/%s', RequestType::GET],
        'payouts_check_eligibility' => ['/payouts/reachability/', RequestType::POST],

        'refunds_get' => ['/refunds/%s', RequestType::GET],
        'refunds_get_for_repudiation' => ['/repudiations/%s/refunds', RequestType::GET],
        'refunds_get_for_transfer' => ['/transfers/%s/refunds', RequestType::GET],
        'refunds_get_for_payin' => ['/payins/%s/refunds', RequestType::GET],
        'refunds_get_for_payout' => ['/payouts/%s/refunds', RequestType::GET],

        'transfers_create' => ['/transfers', RequestType::POST],
        'transfers_get' => ['/transfers/%s', RequestType::GET],
        'transfers_createrefunds' => ['/transfers/%s/refunds', RequestType::POST],

        'users_createnaturals' => ['/users/natural', RequestType::POST],
        'users_createnaturals_sca' => ['/sca/users/natural', RequestType::POST],
        'users_createlegals' => ['/users/legal', RequestType::POST],
        'users_createlegals_sca' => ['/sca/users/legal', RequestType::POST],
        'users_enroll_sca' => ['/sca/users/%s/enrollment', RequestType::POST],
        'users_manage_consent' => ['/sca/users/%s/consent', RequestType::POST],

        'users_createbankaccounts_iban' => ['/users/%s/bankaccounts/iban', RequestType::POST],
        'users_createbankaccounts_gb' => ['/users/%s/bankaccounts/gb', RequestType::POST],
        'users_createbankaccounts_us' => ['/users/%s/bankaccounts/us', RequestType::POST],
        'users_createbankaccounts_ca' => ['/users/%s/bankaccounts/ca', RequestType::POST],
        'users_createbankaccounts_other' => ['/users/%s/bankaccounts/other', RequestType::POST],

        'users_all' => ['/users', RequestType::GET],
        'users_allwallets' => ['/users/%s/wallets', RequestType::GET],
        'users_allbankaccount' => ['/users/%s/bankaccounts', RequestType::GET],
        'users_allcards' => ['/users/%s/cards', RequestType::GET],
        'users_alltransactions' => ['/users/%s/transactions', RequestType::GET],
        'users_allkycdocuments' => ['/users/%s/KYC/documents', RequestType::GET],
        'users_allmandates' => ['/users/%s/mandates', RequestType::GET],
        'users_allbankaccount_mandates' => ['/users/%s/bankaccounts/%s/mandates', RequestType::GET],
        'users_get' => ['/users/%s', RequestType::GET],
        'users_get_sca' => ['/sca/users/%s', RequestType::GET],
        'users_getnaturals' => ['/users/natural/%s', RequestType::GET],
        'users_getnaturals_sca' => ['/sca/users/natural/%s', RequestType::GET],
        'users_getlegals' => ['/users/legal/%s', RequestType::GET],
        'users_getlegals_sca' => ['/sca/users/legal/%s', RequestType::GET],
        'users_getbankaccount' => ['/users/%s/bankaccounts/%s', RequestType::GET],
        'users_savenaturals' => ['/users/natural/%s', RequestType::PUT],
        'users_savenaturals_sca' => ['/sca/users/natural/%s', RequestType::PUT],
        'users_savelegals' => ['/users/legal/%s', RequestType::PUT],
        'users_savelegals_sca' => ['/sca/users/legal/%s', RequestType::PUT],
        'users_getemoney_year' => ['/users/%s/emoney/%s', RequestType::GET],
        'users_getemoney_month' => ['/users/%s/emoney/%s/%s', RequestType::GET],
        'users_block_status' => ['/users/%s/blockStatus', RequestType::GET],
        'users_block_status_regulatory' => ['/users/%s/Regulatory', RequestType::GET],
        'users_categorizenaturals_sca' => ['/sca/users/natural/%s/category', RequestType::PUT],
        'users_categorizelegals_sca' => ['/sca/users/legal/%s/category', RequestType::PUT],
        'users_close_natural' => ['/users/natural/%s', RequestType::DELETE],
        'users_close_legal' => ['/users/legal/%s', RequestType::DELETE],

        'validate_the_format_of_user_data' => ['/users/data-formats/validation', RequestType::POST],

        'bankaccounts_save' => ['/users/%s/bankaccounts/%s', RequestType::PUT],

        'wallets_create' => ['/wallets', RequestType::POST],
        'wallets_alltransactions' => ['/wallets/%s/transactions', RequestType::GET],
        'wallets_get' => ['/wallets/%s', RequestType::GET],
        'wallets_get_sca' => ['/wallets/%s?ScaContext=%s', RequestType::GET],
        'wallets_save' => ['/wallets/%s', RequestType::PUT],

        'kyc_documents_create' => ['/users/%s/KYC/documents/', RequestType::POST],
        'kyc_documents_get' => ['/users/%s/KYC/documents/%s', RequestType::GET],
        'kyc_documents_save' => ['/users/%s/KYC/documents/%s', RequestType::PUT],
        'kyc_page_create' => ['/users/%s/KYC/documents/%s/pages', RequestType::POST],
        'kyc_documents_all' => ['/KYC/documents', RequestType::GET],
        'kyc_documents_get_alt' => ['/KYC/documents/%s', RequestType::GET],
        'kyc_documents_create_consult' => ['/KYC/documents/%s/consult', RequestType::POST],

        'disputes_get' => ['/disputes/%s', RequestType::GET],
        'disputes_save_tag' => ['/disputes/%s', RequestType::PUT],
        'disputes_save_contest_funds' => ['/disputes/%s/submit', RequestType::PUT],
        'dispute_save_close' => ['/disputes/%s/close', RequestType::PUT],

        'disputes_get_transactions' => ['/disputes/%s/transactions', RequestType::GET],

        'disputes_all' => ['/disputes', RequestType::GET],
        'disputes_get_for_wallet' => ['/wallets/%s/disputes', RequestType::GET],
        'disputes_get_for_user' => ['/users/%s/disputes', RequestType::GET],
        'disputes_get_for_payin' => ['/payins/%s/disputes', RequestType::GET],

        'disputes_document_create' => ['/disputes/%s/documents', RequestType::POST],
        'disputes_document_page_create' => ['/disputes/%s/documents/%s/pages', RequestType::POST],
        'disputes_document_save' => ['/disputes/%s/documents/%s', RequestType::PUT],
        'disputes_document_get' => ['/dispute-documents/%s', RequestType::GET],
        'disputes_document_get_for_dispute' => ['/disputes/%s/documents', RequestType::GET],
        'disputes_document_all' => ['/dispute-documents', RequestType::GET],
        'disputes_document_create_consult' => ['/dispute-documents/%s/consult', RequestType::POST],

        'disputes_repudiation_get' => ['/repudiations/%s', RequestType::GET],

        'disputes_repudiation_create_settlement' => ['/repudiations/%s/settlementtransfer', RequestType::POST],
        'disputes_repudiation_get_settlement' => ['/settlements/%s', RequestType::GET],
        'disputes_pendingsettlement' => ['/disputes/pendingsettlement', RequestType::GET],

        'mandates_create' => ['/mandates/directdebit/web', RequestType::POST],
        'mandates_save' => ['/mandates/%s/cancel', RequestType::PUT],
        'mandates_get' => ['/mandates/%s', RequestType::GET],
        'mandates_all' => ['/mandates', RequestType::GET],

        'client_get' => ['/clients', RequestType::GET],
        'client_save' => ['/clients', RequestType::PUT],
        'client_upload_logo' => ['/clients/logo', RequestType::PUT],
        'client_wallets' => ['/clients/wallets', RequestType::GET],
        'client_wallets_fees' => ['/clients/wallets/fees', RequestType::GET],
        'client_wallets_fees_currency' => ['/clients/wallets/fees/%s', RequestType::GET],
        'client_wallets_credit' => ['/clients/wallets/credit', RequestType::GET],
        'client_wallets_credit_currency' => ['/clients/wallets/credit/%s', RequestType::GET],
        'client_wallets_transactions' => ['/clients/transactions', RequestType::GET],
        'client_wallets_transactions_fees_currency' => ['/clients/wallets/fees/%s/transactions', RequestType::GET],
        'client_wallets_transactions_credit_currency' => ['/clients/wallets/credit/%s/transactions', RequestType::GET],
        'client_create_bank_account_iban' => ['/clients/bankaccounts/iban', RequestType::POST],
        'client_create_payout' => ['/clients/payouts', RequestType::POST],
        'client_create_bank_wire_direct_payin' => ['/clients/payins/bankwire/direct', RequestType::POST],

        'banking_aliases_iban_create' => ['/wallets/%s/bankingaliases/iban', RequestType::POST],
        'banking_aliases_get' => ['/bankingaliases/%s', RequestType::GET],
        'banking_aliases_update' => ['/bankingaliases/%s', RequestType::PUT],
        'banking_aliases_all' => ['/wallets/%s/bankingaliases', RequestType::GET],

        'reports_transactions_create' => ['/reports/transactions', RequestType::POST],
        'reports_wallets_create' => ['/reports/wallets', RequestType::POST],
        'reports_all' => ['/reports', RequestType::GET],
        'reports_get' => ['/reports/%s', RequestType::GET],

        'reports_create' => ['/reporting/reports', RequestType::POST],
        'reports_get_v2' => ['/reporting/reports/%s', RequestType::GET],
        'reports_all_v2' => ['/reporting/reports', RequestType::GET],

        'ubo_declaration_create' => ['/users/%s/kyc/ubodeclarations', RequestType::POST],
        'ubo_declaration_all' => ['/users/%s/kyc/ubodeclarations', RequestType::GET],
        'ubo_declaration_submit' => ['/users/%s/kyc/ubodeclarations/%s', RequestType::PUT],
        'ubo_declaration_get' => ['/users/%s/kyc/ubodeclarations/%s', RequestType::GET],
        'ubo_declaration_get_by_id' => ['/kyc/ubodeclarations/%s', RequestType::GET],
        'ubo_create' => ['/users/%s/kyc/ubodeclarations/%s/ubos', RequestType::POST],
        'ubo_update' => ['/users/%s/kyc/ubodeclarations/%s/ubos/%s', RequestType::PUT],
        'ubo_get' => ['/users/%s/kyc/ubodeclarations/%s/ubos/%s', RequestType::GET],

        'transactions_get_for_mandate' => ['/mandates/%s/transactions', RequestType::GET],
        'transactions_get_for_card' => ['/cards/%s/transactions', RequestType::GET],
        'transactions_get_for_bank_account' => ['/bankaccounts/%s/transactions', RequestType::GET],

        'country_authorization_get' => ['/countries/%s/authorizations', RequestType::GET],
        'country_authorization_all' => ['/countries/authorizations', RequestType::GET],

        'deposits_create' => ['/deposit-preauthorizations/card/direct', RequestType::POST],
        'deposits_get' => ['/deposit-preauthorizations/%s', RequestType::GET],
        'deposits_update' => ['/deposit-preauthorizations/%s', RequestType::PUT],
        'deposits_get_all_for_user' => ['/users/%s/deposit-preauthorizations', RequestType::GET],
        'deposits_get_all_for_card' => ['/cards/%s/deposit-preauthorizations', RequestType::GET],
        'deposits_get_transactions' => ['/deposit-preauthorizations/%s/transactions', RequestType::GET],

        'get_conversion_rate' => ['/conversions/rate/%s/%s', RequestType::GET],
        'create_client_wallets_instant_conversion' => ['/clients/conversions/instant-conversion', RequestType::POST],
        'create_instant_conversion' => ['/conversions/instant-conversion', RequestType::POST],
        'create_quoted_conversion' => ['/conversions/quoted-conversion', RequestType::POST],
        'create_client_wallets_quoted_conversion' => ['/clients/conversions/quoted-conversion', RequestType::POST],
        'get_conversion' => ['/conversions/%s', RequestType::GET],
        'create_conversion_quote' => ['/conversions/quote', RequestType::POST],
        'get_conversion_quote' => ['/conversions/quote/%s', RequestType::GET],

        'virtual_account_create' => ['/wallets/%s/virtual-accounts', RequestType::POST],
        'virtual_account_deactivate' => ['/wallets/%s/virtual-accounts/%s', RequestType::PUT],
        'virtual_account_get' => ['/wallets/%s/virtual-accounts/%s', RequestType::GET],
        'virtual_account_get_all' => ['/wallets/%s/virtual-accounts', RequestType::GET],
        'virtual_account_get_availabilities' => ['/virtual-accounts/availability', RequestType::GET],

        'identity_verification_create' => ['/users/%s/identity-verifications', RequestType::POST],
        'identity_verification_get' => ['/identity-verifications/%s', RequestType::GET],
        'identity_verification_get_all' => ['/users/%s/identity-verifications', RequestType::GET],

        'recipients_create' => ['/users/%s/recipients', RequestType::POST],
        'recipients_get' => ['/recipients/%s', RequestType::GET],
        'recipients_get_all' => ['/users/%s/recipients', RequestType::GET],
        'recipients_get_payout_methods' => ['/recipients/payout-methods?country=%s&currency=%s', RequestType::GET],
        'recipients_get_schema' => ['/recipients/schema?payoutMethodType=%s&recipientType=%s&currency=%s&country=%s', RequestType::GET],
        'recipients_validate' => ['/users/%s/recipients/validate', RequestType::POST],
        'recipients_deactivate' => ['/recipients/%s', RequestType::PUT],

        'pay_by_bank_get_supported_banks' => ['/payment-methods/openbanking/metadata/supported-banks', RequestType::GET]
    ];

    /**
     * Constructor
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @param \MangoPay\MangoPayApi $root
     */
    public function __construct($root)
    {
        $this->_root = $root;
    }

    /**
     * Get URL for REST Mango Pay API
     * @param string $key Key with data
     * @return string
     */
    protected function GetRequestUrl($key)
    {
        return $this->_methods[$key][0];
    }

    /**
     * Get request type for REST Mango Pay API
     * @param string $key Key with data
     * @return RequestType
     */
    protected function GetRequestType($key)
    {
        return $this->_methods[$key][1];
    }

    protected function GetApiVersion($key)
    {
        if (sizeof($this->_methods[$key]) == 3) {
            return $this->_methods[$key][2];
        }
        return "v2.01";
    }

    /**
     * Create object in API
     * @param string $methodKey Key with request data
     * @param object $entity Entity object
     * @param object $responseClassName Name of entity class from response
     * @param string $entityId Entity identifier
     * @return object Response data
     */
    protected function CreateObject($methodKey, $entity, $responseClassName = null, $entityId = null, $subEntityId = null, $idempotencyKey = null)
    {
        if (is_null($entityId)) {
            $urlMethod = $this->GetRequestUrl($methodKey);
        } elseif (is_null($subEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        } else {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $subEntityId);
        }

        $requestData = null;
        if (!is_null($entity)) {
            $requestData = $this->BuildRequestData($entity);
        }

        if (is_null($requestData) && $responseClassName == '\MangoPay\UboDeclaration') {
            $requestData = "";
        }

        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey), $requestData, $idempotencyKey);
        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * @param string $methodKey Key with request data
     * @param string $file The file content (raw binary string)
     * @param string $fileName The file name
     * @param string $responseClassName Name of entity class from response
     * @param string $entityId Optional entity identifier
     * @param string $idempotencyKey Optional idempotency key
     * @return object Response data
     * @throws Exception
     */
    protected function CreateOrUpdateMultipartObject($methodKey, $file, $fileName, $responseClassName = null, $entityId = null, $idempotencyKey = null)
    {
        if (is_null($entityId)) {
            $urlMethod = $this->GetRequestUrl($methodKey);
        } else {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        }

        if (is_null($file)) {
            throw new Exception('The file param must not be null');
        }

        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true);
        $response = $rest->RequestMultipart($urlMethod, $apiVersion, $this->GetRequestType($methodKey), $file, $fileName, $idempotencyKey);
        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * Get entity object from API
     * @param string $methodKey Key with request data
     * @param object $responseClassName Name of entity class from response
     * @return object Response data
     * @throws Exception
     */
    protected function GetObject($methodKey, $responseClassName, $firstEntityId = null, $secondEntityId = null, $thirdEntityId = null, $clientIdRequired = true)
    {
        if (!is_null($thirdEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $firstEntityId, $secondEntityId, $thirdEntityId);
        } elseif (!is_null($secondEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $firstEntityId, $secondEntityId);
        } elseif (!is_null($firstEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $firstEntityId);
        } else {
            $urlMethod = $this->GetRequestUrl($methodKey);
        }

        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true, $clientIdRequired);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey));

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }
        return $response;
    }

    /**
     * Get entity object from API endpoint that has a lot of query params
     * @param string $methodKey Key with request data
     * @param object $responseClassName Name of entity class from response
     * @return object Response data
     * @throws Exception
     */
    protected function GetObjectManyQueryParams($methodKey, $responseClassName, ...$queryParams)
    {
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), ...$queryParams);
        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true, true);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey));

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }
        return $response;
    }

    /**
     * Get entity object from API on a request path that contains pagination and other query params
     * @param string $methodKey Key with request data
     * @param object $responseClassName Name of entity class from response
     * @return object Response data
     * @throws Exception
     */
    protected function GetObjectWithPagination(
        $methodKey,
        $responseClassName,
        $pagination = null,
        $filter = null,
        $clientIdRequired = true
    ) {
        $urlPath = $this->GetRequestUrl($methodKey);

        if (is_null($pagination) || !is_object($pagination) || get_class($pagination) != 'MangoPay\Pagination') {
            $pagination = new \MangoPay\Pagination();
        }

        $additionalUrlParams = [];
        if (!is_null($filter)) {
            $additionalUrlParams["filter"] = $filter;
        }

        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true, $clientIdRequired);
        $response = $rest->Request($urlPath, $apiVersion, $this->GetRequestType($methodKey), null, null, $pagination, $additionalUrlParams);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }
        return $response;
    }

    /**
     * Get lst with entities object from API
     * @param string $methodKey Key with request data
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param object $responseClassName Name of entity class from response
     * @param string $entityId Entity identifier
     * @param object $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return object[] Response data
     */
    protected function GetList($methodKey, &$pagination, $responseClassName = null, $entityId = null, $filter = null, $sorting = null, $secondEntityId = null, $clientIdRequired = true)
    {
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $secondEntityId);

        if (is_null($pagination) || !is_object($pagination) || get_class($pagination) != 'MangoPay\Pagination') {
            $pagination = new \MangoPay\Pagination();
        }

        $rest = new RestTool($this->_root, true, $clientIdRequired);
        $additionalUrlParams = [];
        if (!is_null($filter)) {
            $additionalUrlParams["filter"] = $filter;
        }
        if (!is_null($sorting)) {
            if (!is_a($sorting, "\MangoPay\Sorting")) {
                throw new Exception('Wrong type of sorting object');
            }

            $additionalUrlParams["sort"] = $sorting->GetSortParameter();
        }

        $apiVersion = $this->GetApiVersion($methodKey);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey), null, null, $pagination, $additionalUrlParams);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * Save object in API
     * @param string $methodKey Key with request data
     * @param object $entity Entity object to save
     * @param object $responseClassName Name of entity class from response
     * @return object Response data
     */
    protected function SaveObject($methodKey, $entity, $responseClassName = null, $secondEntityId = null, $thirdEntityId = null)
    {
        $entityId = null;
        if (isset($entity->Id)) {
            $entityId = $entity->Id;
        }

        if (is_null($secondEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        } elseif (is_null($thirdEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $secondEntityId, $entityId);
        } else {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $secondEntityId, $thirdEntityId, $entityId);
        }

        $requestData = $this->BuildRequestData($entity);

        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey), $requestData);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    protected function DeleteObject($methodKey, $entity, $responseClassName = null)
    {
        if (!isset($entity->Id)) {
            throw new Exception('The entity must have the Id set');
        }

        $apiVersion = $this->GetApiVersion($methodKey);
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entity->Id);
        $rest = new RestTool($this->_root, true);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey));

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * Executes a POST request
     * @param $methodKey Key with request data
     * @param $entity Entity object
     * @param $responseClassName Name of entity class from response
     * @param $entityId Entity identifier
     * @return object Response data
     */
    protected function ExecutePostRequest($methodKey, $entity, $responseClassName, $entityId = null, $idempotency_key = null)
    {
        if ($entityId != null) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        } else {
            $urlMethod = $this->GetRequestUrl($methodKey);
        }

        $requestData = $this->BuildRequestData($entity);
        $apiVersion = $this->GetApiVersion($methodKey);
        $rest = new RestTool($this->_root, true);
        $response = $rest->Request($urlMethod, $apiVersion, $this->GetRequestType($methodKey), $requestData, $idempotency_key);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * Cast response object to an error object
     * @param object $response Object from API response
     * @return Error The error
     */
    protected function CastResponseToError($response)
    {
        // This logic is similar to RestTool::CheckResponseCode
        $error = new Error();

        $map = [
            'Message',
            'Id',
            'Type',
            'Date',
            'Errors',
        ];

        foreach ($map as $val) {
            $error->{$val} = property_exists($response, $val) ? $response->{$val} : null;
        }

        if (property_exists($response, 'errors')) {
            $error->Errors = $response->errors;
        }

        if (is_array($error->Errors)) {
            foreach ($error->Errors as $key => $val) {
                $error->Message .= sprintf(' %s error: %s', $key, $val);
            }
        }

        return $error;
    }

    /**
     * Cast response object to entity object
     * @param object $response Object from API response
     * @param string $entityClassName Name of entity class to cast
     * @return \MangoPay\$entityClassName Return entity object
     */
    protected function CastResponseToEntity($response, $entityClassName, $asDependentObject = false)
    {
        if (is_array($response)) {
            $list = [];
            foreach ($response as $responseObject) {
                array_push($list, $this->CastResponseToEntity($responseObject, $entityClassName));
            }

            return $list;
        }

        if (is_string($entityClassName)) {
            $entity = new $entityClassName();
        } else {
            throw new Exception("Cannot cast response to entity object. Wrong entity class name");
        }

        $responseReflection = new \ReflectionObject($response);
        $entityReflection = new \ReflectionObject($entity);
        $responseProperties = $responseReflection->getProperties();

        $subObjects = $entity->GetSubObjects();
        $dependsObjects = $entity->GetDependsObjects();

        foreach ($responseProperties as $responseProperty) {
            $responseProperty->setAccessible(true);

            $name = $responseProperty->getName();
            $value = $responseProperty->getValue($response);

            if ($entityReflection->hasProperty($name)) {
                $entityProperty = $entityReflection->getProperty($name);
                $entityProperty->setAccessible(true);

                if ($entityProperty->getName() == "DeclaredUBOs") {
                    $declaredUbos = [];
                    foreach ($value as $declaredUboRaw) {
                        $declaredUbo = new \MangoPay\DeclaredUbo();
                        $declaredUbo->UserId = $declaredUboRaw->UserId;
                        $declaredUbo->Status = $declaredUboRaw->Status;
                        $declaredUbo->RefusedReasonType = $declaredUboRaw->RefusedReasonMessage;
                        $declaredUbo->RefusedReasonMessage = $declaredUboRaw->RefusedReasonMessage;
                        array_push($declaredUbos, $declaredUbo);
                    }
                    $value = $declaredUbos;
                }

                // is sub object?
                if (isset($subObjects[$name])) {
                    $object = null;
                    if (!is_null($value)) {
                        if (is_array($subObjects[$name])) {
                            $type = $subObjects[$name][0];
                            $class = $subObjects[$name][1];

                            if ($value instanceof \stdClass) {
                                $value = (array)$value;
                            }

                            // handle single array
                            if ($type === 'array_single') {
                                $object = [];
                                foreach ($value as $k => $subValue) {
                                    $object[$k] = $this->CastResponseToEntity($subValue, $class);
                                }
                            } elseif ($type === 'array_nested') {
                                // handle nested array
                                $object = [];
                                foreach ($value as $k => $subValue) {
                                    if ($subValue instanceof \stdClass) {
                                        $subValue = (array)$subValue;
                                    }
                                    $nestedArray = [];
                                    foreach ($subValue as $nk => $nestedObj) {
                                        $nestedArray[$nk] = $this->CastResponseToEntity($nestedObj, $class);
                                    }
                                    $object[$k] = $nestedArray;
                                }
                            }
                        } else {
                            $object = $this->CastResponseToEntity($value, $subObjects[$name]);
                        }
                    }
                    $entityProperty->setValue($entity, $object);
                } else {
                    $entityProperty->setValue($entity, $value);
                }

                // has dependent object?
                if (isset($dependsObjects[$name])) {
                    $dependsObject = $dependsObjects[$name];
                    $entityDependProperty = $entityReflection->getProperty($dependsObject['_property_name']);
                    $entityDependProperty->setAccessible(true);
                    $entityDependProperty->setValue($entity, $this->CastResponseToEntity($response, $dependsObject[$value], true));
                }
            } else {
                if ($asDependentObject || !empty($dependsObjects)) {
                    continue;
                } else {
                    /* UNCOMMENT THE LINE BELOW TO ENABLE RESTRICTIVE REFLECTION MODE */
                    //throw new Exception('Cannot cast response to entity object. Missing property ' . $name .' in entity ' . $entityClassName);

                    continue;
                }
            }
        }

        return $entity;
    }

    /**
     * Get array with request data
     * @param object $entity Entity object to send as request data
     * @return array
     */
    protected function BuildRequestData($entity)
    {
        /*if (is_a($entity, 'MangoPay\UboDeclaration')) {
            $declaredUboIds = [];
            foreach ($entity->DeclaredUBOs as $declaredUBO) {
                if (is_string($declaredUBO)) {
                    array_push($declaredUboIds, $declaredUBO);
                } else {
                    array_push($declaredUboIds, $declaredUBO->UserId);
                }
            }
            $entity->DeclaredUBOs = $declaredUboIds;
        }*/
        if (method_exists($entity, 'GetReadOnlyProperties')) {
            $blackList = $entity->GetReadOnlyProperties();
        } else {
            $blackList = [];
        }
        $entityProperties = get_object_vars($entity);
        $requestData = [];
        foreach ($entityProperties as $propertyName => $propertyValue) {
            if (in_array($propertyName, $blackList)) {
                continue;
            }

            if ($this->CanReadSubRequestData($entity, $propertyName)) {
                $subRequestData = $this->BuildRequestData($propertyValue);
                foreach ($subRequestData as $key => $value) {
                    $requestData[$key] = $value;
                }
            } else {
                if (isset($propertyValue)) {
                    $requestData[$propertyName] = $propertyValue;
                }
            }
        }

        if (count($requestData) == 0) {
            return new \stdClass();
        }
        return $requestData;
    }

    private function CanReadSubRequestData($entity, $propertyName)
    {
        if (get_class($entity) == 'MangoPay\PayIn' &&
            ($propertyName == 'PaymentDetails' || $propertyName == 'ExecutionDetails')) {
            return true;
        }

        if (get_class($entity) == 'MangoPay\PayOut' && $propertyName == 'MeanOfPaymentDetails') {
            return true;
        }

        if (get_class($entity) == 'MangoPay\BankAccount' && $propertyName == 'Details') {
            return true;
        }

        return false;
    }

    protected function GetObjectForIdempotencyUrl($url)
    {
        if (is_null($url) || empty($url)) {
            return null;
        }

        $map = [
            'preauthorization_create' => '\MangoPay\CardPreAuthorization',
            'cardregistration_create' => '\MangoPay\CardRegistration',
            'client_upload_logo' => '',
            'disputes_repudiation_create_settlement' => '\MangoPay\Transfer',
            'disputes_document_create' => '\MangoPay\DisputeDocument',
            'disputes_document_page_create' => '',
            'hooks_create' => '\MangoPay\Hook',
            'mandates_create' => '\MangoPay\Mandate',
            'payins_card-web_create' => '\MangoPay\PayIn',
            'payins_card-direct_create' => '\MangoPay\PayIn',
            'payins_preauthorized-direct_create' => '\MangoPay\PayIn',
            'payins_bankwire-direct_create' => '\MangoPay\PayIn',
            'payins_directdebit-web_create' => '\MangoPay\PayIn',
            'payins_directdebit-direct_create' => '\MangoPay\PayIn',
            'payins_createrefunds' => '\MangoPay\Refund',
            'payouts_bankwire_create' => '\MangoPay\PayOut',
            'payouts_bankwire_get' => '\MangoPay\Payout',
            'reports_transactions_create' => '\MangoPay\ReportRequest',
            'reports_wallets_create' => '\MangoPay\ReportRequest',
            'reports_create' => '\MangoPay\Report',
            'transfers_createrefunds' => '\MangoPay\Refund',
            'transfers_create' => '\MangoPay\Transfer',
            'users_createnaturals' => '\MangoPay\UserNatural',
            'users_createnaturals_sca' => '\MangoPay\UserNaturalSca',
            'users_createlegals' => '\MangoPay\UserLegal',
            'users_createlegals_sca' => '\MangoPay\UserLegalSca',
            'users_createbankaccounts_iban' => '\MangoPay\BankAccount',
            'users_createbankaccounts_gb' => '\MangoPay\BankAccount',
            'users_createbankaccounts_us' => '\MangoPay\BankAccount',
            'users_createbankaccounts_ca' => '\MangoPay\BankAccount',
            'users_createbankaccounts_other' => '\MangoPay\BankAccount',
            'virtual_account_create' => '\MangoPay\VirtualAccount',
            'kyc_documents_create' => '\MangoPay\KycDocument',
            'kyc_page_create' => '',
            'wallets_create' => '\MangoPay\Wallet',
            'users_getemoney_year' => '\MangoPay\EMoney',
            'users_getemoney_month' => '\MangoPay\EMoney',
            'payins_recurring_paypal' => '\MangoPay\PayInRecurring',
            'identity_verification_create' => '\MangoPay\IdentityVerification',
            'recipients_create' => '\MangoPay\Recipient',
            'payins_intent_create_splits' => '\MangoPay\IntentSplits',
            'payins_intent_create_authprization' => '\MangoPay\PayInIntent',
            'payins_intent_create_capture' => '\MangoPay\PayInIntent',
            'settlement_generate_upload_url' => '\MangoPay\Settlement',
            'payins_intent_execute_split' => '\MangoPay\PayInIntentSplit',
            'payins_intent_reverse_split' => '\MangoPay\PayInIntentSplit'
        ];

        foreach ($map as $key => $className) {
            $sourceUrl = $this->GetRequestUrl($key);
            $sourceUrl = str_replace("%s", "[0-9a-zA-Z_-]*", $sourceUrl);
            $sourceUrl = str_replace("/", "\/", $sourceUrl);
            $pattern = '/' . $sourceUrl . '/';
            if (preg_match($pattern, $url) > 0) {
                return $className;
            }
        }

        return null;
    }
}
