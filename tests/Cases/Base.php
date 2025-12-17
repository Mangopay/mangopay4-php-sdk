<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Address;
use MangoPay\BankAccount;
use MangoPay\BankAccountDetailsIBAN;
use MangoPay\BankingAliasType;
use MangoPay\Billing;
use MangoPay\Birthplace;
use MangoPay\BrowserInfo;
use MangoPay\CreateDeposit;
use MangoPay\CurrencyIso;
use MangoPay\LegalPersonType;
use MangoPay\LegalRepresentative;
use MangoPay\Libraries\Exception;
use MangoPay\LineItem;
use MangoPay\Money;
use MangoPay\PayInIntent;
use MangoPay\PayInIntentBuyer;
use MangoPay\PayInIntentExternalData;
use MangoPay\PayInIntentLineItem;
use MangoPay\PayInIntentSeller;
use MangoPay\ShippingPreference;
use MangoPay\Tests\Mocks\MockStorageStrategy;
use MangoPay\Ubo;
use MangoPay\UserCategory;
use MangoPay\UserLegalSca;
use MangoPay\UserNatural;
use MangoPay\UserNaturalSca;
use MangoPay\VirtualAccount;
use PHPUnit\Framework\TestCase;

set_time_limit(0);

/**
 * Base class for test case classes
 */
abstract class Base extends TestCase
{
    /**
     * Test user (natural) - access by getJohn()
     * @var UserNatural
     */
    public static $John;

    /**
     * Test user (natural) - access by getJohn()
     * @var UserNatural
     */
    public static $JohnPayer;

    /**
     * Test user (natural) - access by getJohn()
     * @var UserNaturalSca
     */
    public static $JohnScaPayer;

    /**
     * Test user (natural) - access by getJohn()
     * @var UserNaturalSca
     */
    public static $JohnScaOwner;

    /**
     * Test user (legal) - access by getMatrix()
     * @var \MangoPay\UserLegal
     */
    public static $Matrix;

    /**
     * Test user (legal) - access by getJohn()
     * @var UserLegalSca
     */
    public static $MatrixScaPayer;

    /**
     * Test user (legal) - access by getJohn()
     * @var UserLegalSca
     */
    public static $MatrixScaOwner;

    /**
     * @var \MangoPay\UboDeclaration
     */
    public static $MatrixUboDeclaration;
    /**
     * @var \MangoPay\Ubo
     */
    public static $MatrixUbo;
    /**
     * Test bank account belonging to John - access by getJohnsAccount()
     * @var \MangoPay\BankAccount
     */
    public static $JohnsAccount;
    /**
     * Test wallets belonging to John - access by getJohnsWallet()
     * @var \MangoPay\Wallet
     */
    public static $JohnsWallet;
    public static $johnsVirtualAccount;
    /**
     * Test Kyc Document belonging to John
     * @var \MangoPay\KycDocument
     */
    public static $JohnsKycDocument;
    /**
     * Test wallets belonging to John with money - access by getJohnsWalletWithMoney()
     * @var \MangoPay\Wallet
     */
    public static $JohnsWalletWithMoney;
    /**
     * Test pay-ins Card Web object
     * @var \MangoPay\PayIn
     */
    public static $JohnsPayInCardWeb;
    /** @var \MangoPay\PayInPaymentDetailsCard */
    public static $PayInPaymentDetailsCard;
    /** @var \MangoPay\PayInExecutionDetailsWeb */
    public static $PayInExecutionDetailsWeb;
    /**
     * Test pay-ins Card Web object
     * @var \MangoPay\PayIn
     */
    public static $JohnsPayInPaypalWeb;

    public static $JohnsPayInPaypalWebV2;

    /**
     * Test pay-ins Card Web object Payconiq
     * @var \MangoPay\PayIn
     */
    public static $JohnsPayInPayconiqWeb;
    /**
     * Test pay-outs objects
     * @var \MangoPay\PayOut
     */
    public static $JohnsPayOutBankWire;
    public static $JohnsPayOutForCardDirect;
    /**
     * Test card registration object
     * @var \MangoPay\CardRegistration
     */
    public static $JohnsCardRegistration;
    /** @var \MangoPay\Hook */
    public static $JohnsHook;
    /**
     * Test Banking Alias IBAN
     * @var \MangoPay\BankingAliasIBAN
     */
    public static $JohnsBankingAliasIBAN;
    /**
     * Test Banking Alias IBAN
     * @var \MangoPay\BankingAliasIBAN
     */
    public static $JohnsBankingAliasGB;
    /** @var \MangoPay\MangoPayApi */
    protected $_api;

    public function __construct()
    {
        parent::__construct();
        $this->_api = $this->buildNewMangoPayApi();
    }

    protected function buildNewMangoPayApi()
    {
        $api = new \MangoPay\MangoPayApi();

        // use test client credentails
        $api->Config->ClientId = 'sdk-unit-tests';

        // sandbox environment:
        $api->Config->BaseUrl = 'https://api.sandbox.mangopay.com';
        $api->Config->ClientPassword = 'cqFfFrWfCcb7UadHNxx2C9Lo6Djw8ZduLi7J9USTmu8bhxxpju';

        $api->OAuthTokenManager->RegisterCustomStorageStrategy(new MockStorageStrategy());

        return $api;
    }

    /**
     * Creates new user
     * @return UserNatural
     */
    protected function getNewJohn()
    {
        $user = $this->buildJohn();
        return $this->_api->Users->Create($user);
    }

    /**
     * @return UserNatural
     */
    protected function buildJohn()
    {
        $user = new UserNatural();
        $user->FirstName = "John";
        $user->LastName = "Doe";
        $user->Email = "john.doe@sample.org";
        $user->Address = $this->getNewAddress();
        $user->Birthday = mktime(0, 0, 0, 12, 21, 1975);
        $user->Nationality = "FR";
        $user->CountryOfResidence = "FR";
        $user->Occupation = "programmer";
        $user->IncomeRange = 3;
        $user->TermsAndConditionsAccepted = true;
        return $user;
    }

    protected function buildJohnPayer()
    {
        $user = new UserNatural();
        $user->FirstName = "John";
        $user->LastName = "Doe";
        $user->Email = "john.doe@sample.org";
        $user->TermsAndConditionsAccepted = true;
        $user->UserCategory = UserCategory::Payer;
        return $user;
    }

    protected function buildMatrix($john)
    {
        $user = new \MangoPay\UserLegal();
        $user->Name = "MartixSampleOrg";
        $user->Email = "mail@test.com";
        $user->LegalPersonType = LegalPersonType::Business;
        $user->HeadquartersAddress = $this->getNewAddress();
        $user->LegalRepresentativeFirstName = $john->FirstName;
        $user->LegalRepresentativeLastName = $john->LastName;
        $user->LegalRepresentativeAddress = $john->Address;
        $user->LegalRepresentativeEmail = $john->Email;
        $user->LegalRepresentativeBirthday = $john->Birthday;
        $user->LegalRepresentativeNationality = $john->Nationality;
        $user->LegalRepresentativeCountryOfResidence = $john->CountryOfResidence;
        $user->CompanyNumber = "LU123456";
        $user->TermsAndConditionsAccepted = true;
        return $user;
    }

    /**
     * Creates new address
     * @return Address
     */
    protected function getNewAddress()
    {
        $result = new Address();

        $result->AddressLine1 = 'Address line 1';
        $result->AddressLine2 = 'Address line 2';
        $result->City = 'City';
        $result->Country = 'FR';
        $result->PostalCode = '11222';
        $result->Region = 'Region';

        return $result;
    }

    /**
     * Creates self::$JohnsKycDocument (KycDocument belonging to John) if not created yet
     * @return \MangoPay\KycDocument
     */
    protected function getJohnsKycDocument()
    {
        if (self::$JohnsKycDocument === null) {
            $john = $this->getJohn();

            $kycDocument = new \MangoPay\KycDocument();
            $kycDocument->Status = \MangoPay\KycDocumentStatus::Created;
            $kycDocument->Type = \MangoPay\KycDocumentType::IdentityProof;

            self::$JohnsKycDocument = $this->_api->Users->CreateKycDocument($john->Id, $kycDocument);
        }

        return self::$JohnsKycDocument;
    }

    /**
     * Creates self::$John (test natural user) if not created yet
     * @return UserNatural
     */
    protected function getJohn()
    {
        if (self::$John === null) {
            $user = $this->buildJohn();
            self::$John = $this->_api->Users->Create($user);
        }
        return self::$John;
    }

    protected function getJohnPayer()
    {
        if (self::$JohnPayer === null) {
            $user = $this->buildJohnPayer();
            self::$JohnPayer = $this->_api->Users->Create($user);
        }
        return self::$JohnPayer;
    }

    /**
     * @param $userCategory string
     * @param $recreate boolean
     * @return UserNaturalSca
     * @throws Exception
     */
    protected function getJohnSca($userCategory, $recreate)
    {
        switch ($userCategory) {
            case UserCategory::Payer:
                return $this->getJohnScaPayer($recreate);
            case UserCategory::Owner:
                return $this->getJohnScaOwner($recreate);
            default:
                throw new Exception('Unexpected user category');
        }
    }

    /**
     * @param $recreate boolean
     * @return UserNaturalSca
     * @throws Exception
     */
    private function getJohnScaPayer($recreate)
    {
        if (self::$JohnScaPayer === null || $recreate) {
            $user = new UserNaturalSca();
            $user->FirstName = "John SCA";
            $user->LastName = "Doe SCA Review";
            $user->Email = "john.doe.sca@sample.org";
            $user->TermsAndConditionsAccepted = true;
            $user->UserCategory = UserCategory::Payer;
            $user->Address = $this->getNewAddress();
            self::$JohnScaPayer = $this->_api->Users->Create($user);
        }
        return self::$JohnScaPayer;
    }

    /**
     * @param $recreate boolean
     * @return UserNaturalSca
     * @throws Exception
     */
    private function getJohnScaOwner($recreate)
    {
        if (self::$JohnScaOwner === null || $recreate) {
            $user = new UserNaturalSca();
            $user->FirstName = "John SCA";
            $user->LastName = "Doe SCA Review";
            $user->Email = "john.doe.sca@sample.org";
            $user->Address = $this->getNewAddress();
            $user->Birthday = mktime(0, 0, 0, 12, 21, 1975);
            $user->Nationality = "FR";
            $user->CountryOfResidence = "FR";
            $user->Occupation = "programmer";
            $user->IncomeRange = 3;
            $user->UserCategory = UserCategory::Owner;
            $user->TermsAndConditionsAccepted = true;
            $user->PhoneNumber = "+33611111111";
            $user->PhoneNumberCountry = "FR";
            self::$JohnScaOwner = $this->_api->Users->Create($user);
        }
        return self::$JohnScaOwner;
    }

    /**
     * @return \MangoPay\UserLegal|UserNatural
     * @throws \MangoPay\Libraries\Exception
     */
    protected function getJohnWithTermsAccepted()
    {
        $user = $this->buildJohn();
        $user->TermsAndConditionsAccepted = true;
        return $this->_api->Users->Create($user);
    }

    /**
     * Creates self::$JohnsBankingAliasIBAN (Banking alias belonging to John) if not created yet
     * @return \MangoPay\BankingAliasIBAN
     */
    protected function getJohnsBankingAliasIBAN()
    {
        if (self::$JohnsBankingAliasIBAN === null) {
            $john = $this->getJohn();
            $wallet = $this->getJohnsWallet();

            $bankingAliasIBAN = new \MangoPay\BankingAliasIBAN();
            $bankingAliasIBAN->CreditedUserId = $john->Id;
            $bankingAliasIBAN->WalletId = $wallet->Id;
            $bankingAliasIBAN->OwnerName = $john->FirstName;
            $bankingAliasIBAN->Country = "LU";
            $bankingAliasIBAN->Active = "true";

            self::$JohnsBankingAliasIBAN = $this->_api->BankingAliases->Create($bankingAliasIBAN, $wallet->Id);
        }

        return self::$JohnsBankingAliasIBAN;
    }

    /**
     * Creates self::$JohnsBankingAliasIBAN of type GB (Banking alias belonging to John) if not created yet
     * @return \MangoPay\BankingAliasIBAN
     */
    protected function getJohnsBankingAliasGB()
    {
        if (self::$JohnsBankingAliasGB === null) {
            $john = $this->getJohn();
            $wallet = new \MangoPay\Wallet();
            $wallet->Owners = [$john->Id];
            $wallet->Currency = CurrencyIso::GBP;
            $wallet->Description = 'WALLET IN GBP';
            $wallet = $this->_api->Wallets->Create($wallet);

            $localAccountDetails = new \MangoPay\LocalAccountDetailsBankingAlias();
            $localAccountDetails->SortCode = "608382";
            $localAccountDetails->AccountNumber = "21394585";


            $bankingAliasGB = new \MangoPay\BankingAliasIBAN();
            $bankingAliasGB->CreditedUserId = $john->Id;
            $bankingAliasGB->WalletId = $wallet->Id;
            $bankingAliasGB->OwnerName = $john->FirstName;
            $bankingAliasGB->Type = BankingAliasType::GB;
            $bankingAliasGB->Country = "GB";
            $bankingAliasGB->Active = "true";
            $bankingAliasGB->LocalAccountDetails = $localAccountDetails;

            self::$JohnsBankingAliasGB = $this->_api->BankingAliases->Create($bankingAliasGB, $wallet->Id);
        }

        return self::$JohnsBankingAliasGB;
    }

    /**
     * Creates self::$JohnsWallet (wallets belonging to John) if not created yet
     * @return \MangoPay\Wallet
     */
    protected function getJohnsWallet()
    {
        if (self::$JohnsWallet === null) {
            $john = $this->getJohn();

            $wallet = new \MangoPay\Wallet();
            $wallet->Owners = [$john->Id];
            $wallet->Currency = 'EUR';
            $wallet->Description = 'WALLET IN EUR';

            self::$JohnsWallet = $this->_api->Wallets->Create($wallet);
        }

        return self::$JohnsWallet;
    }

    protected function getJohnsWalletForCurrency($currency)
    {
        $john = $this->getJohn();

        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = $currency;
        $wallet->Description = 'WALLET IN ' . $currency;

        return $this->_api->Wallets->Create($wallet);
    }

    protected function getNewVirtualAccount()
    {
        if (self::$johnsVirtualAccount === null) {
            $wallet = $this->getJohnsWallet();
            $virtualAccount = new VirtualAccount();
            $virtualAccount->Country = "FR";
            $virtualAccount->VirtualAccountPurpose = "Collection";
            $virtualAccount->Tag = "create virtual account tag";

            self::$johnsVirtualAccount = $this->_api->VirtualAccounts->Create($virtualAccount, $wallet->Id);
        }

        return self::$johnsVirtualAccount;
    }

    /**
     * Creates Pay-In Card Web object
     * @return \MangoPay\PayIn
     */
    protected function getJohnsPayInCardWeb()
    {
        if (self::$JohnsPayInCardWeb === null) {
            $wallet = $this->getJohnsWallet();
            $user = $this->getJohn();

            $payIn = new \MangoPay\PayIn();
            $payIn->AuthorId = $user->Id;
            $payIn->CreditedUserId = $user->Id;
            $payIn->DebitedFunds = new \MangoPay\Money();
            $payIn->DebitedFunds->Currency = 'EUR';
            $payIn->DebitedFunds->Amount = 1000;
            $payIn->Fees = new \MangoPay\Money();
            $payIn->Fees->Currency = 'EUR';
            $payIn->Fees->Amount = 5;
            $payIn->CreditedWalletId = $wallet->Id;
            $payIn->PaymentDetails = $this->getPayInPaymentDetailsCard();
            $payIn->ExecutionDetails = $this->getPayInExecutionDetailsWeb();

            //Add for PAYLINEV2 parameter support. You must now use this object for Payin Card only
            $payIn->ExecutionDetails->TemplateURLOptions = new \MangoPay\PayInCardTemplateURLOptions();
            $payIn->ExecutionDetails->TemplateURLOptions->PAYLINE = "https://www.maysite.com/payline_template/";
            $payIn->ExecutionDetails->TemplateURLOptions->PAYLINEV2 = "https://www.maysite.com/payline_template/";

            self::$JohnsPayInCardWeb = $this->_api->PayIns->Create($payIn);
        }

        return self::$JohnsPayInCardWeb;
    }

    /**
     * @return \MangoPay\PayInPaymentDetailsCard
     */
    private function getPayInPaymentDetailsCard()
    {
        if (self::$PayInPaymentDetailsCard === null) {
            self::$PayInPaymentDetailsCard = new \MangoPay\PayInPaymentDetailsCard();
            self::$PayInPaymentDetailsCard->CardType = 'CB_VISA_MASTERCARD';
            self::$PayInPaymentDetailsCard->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
            self::$PayInPaymentDetailsCard->BrowserInfo = $this->getBrowserInfo();
        }

        return self::$PayInPaymentDetailsCard;
    }

    /**
     * @return \MangoPay\PayInExecutionDetailsWeb
     */
    private function getPayInExecutionDetailsWeb()
    {
        if (self::$PayInExecutionDetailsWeb === null) {
            self::$PayInExecutionDetailsWeb = new \MangoPay\PayInExecutionDetailsWeb();
            self::$PayInExecutionDetailsWeb->ReturnURL = 'https://test.com';
            self::$PayInExecutionDetailsWeb->TemplateURL = 'https://TemplateURL.com';
            self::$PayInExecutionDetailsWeb->SecureMode = 'DEFAULT';
            self::$PayInExecutionDetailsWeb->Culture = 'fr';
        }

        return self::$PayInExecutionDetailsWeb;
    }

    /**
     * Creates Pay-In direct debit direct object
     * @return \MangoPay\PayIn
     */
    protected function getNewPayInDirectDebitDirect($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }
        $mandate = $this->getJohnsMandate();

        // create pay-in CARD DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
        $payIn->PaymentDetails->MandateId = $mandate->Id;
        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        return $this->_api->PayIns->Create($payIn);
    }

    /**
     * Creates self::$JohnsWalletWithMoney (wallets belonging to John) if not created yet (3DSecure)
     * @return array<int,string>
     * @phpstan-return {walletId: string, cardId?: string }
     */
    protected function getJohnsWalletWithMoneyAndCardId($amount = 1000)
    {
        $arr = [];
        if (self::$JohnsWalletWithMoney === null) {
            $john = $this->getJohn();
            // create wallet with money
            $wallet = new \MangoPay\Wallet();
            $wallet->Owners = [$john->Id];
            $wallet->Currency = 'EUR';
            $wallet->Description = 'WALLET IN EUR WITH MONEY';

            self::$JohnsWalletWithMoney = $this->_api->Wallets->Create($wallet);

            $cardRegistration = new \MangoPay\CardRegistration();
            $cardRegistration->UserId = self::$JohnsWalletWithMoney->Owners[0];
            $cardRegistration->Currency = 'EUR';
            $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);

            $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);
            $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

            $card = $this->_api->Cards->Get($cardRegistration->CardId);

            // create pay-in CARD DIRECT
            $payIn = new \MangoPay\PayIn();
            $payIn->CreditedWalletId = self::$JohnsWalletWithMoney->Id;
            $payIn->AuthorId = $cardRegistration->UserId;
            $payIn->DebitedFunds = new \MangoPay\Money();
            $payIn->DebitedFunds->Amount = $amount;
            $payIn->DebitedFunds->Currency = 'EUR';
            $payIn->Fees = new \MangoPay\Money();
            $payIn->Fees->Amount = 0;
            $payIn->Fees->Currency = 'EUR';

            // payment type as CARD
            $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
            $payIn->PaymentDetails->CardId = $card->Id;
            $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
            $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();

            // execution type as DIRECT
            $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
            $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
            // create Pay-In
            $this->_api->PayIns->Create($payIn);
            $arr["cardId"] = $card->Id;
        }

        $wall = $this->_api->Wallets->Get(self::$JohnsWalletWithMoney->Id);
        $arr["walletId"] = $wall->Id;

        return $arr;
    }

    /**
     * Creates self::$JohnsWalletWithMoney (wallets belonging to John) if not created yet
     * @return \MangoPay\Wallet
     */
    protected function getJohnsWalletWithMoney($amount = 1000)
    {
        if (self::$JohnsWalletWithMoney === null) {
            $john = $this->getJohn();
            self::$JohnsWalletWithMoney = $this->createNewWallet($john->Id);
            $cardRegistration = $this->createNewCardRegistration($john->Id);
            $this->createNewPayInCardDirect($john->Id, $cardRegistration->CardId, self::$JohnsWalletWithMoney->Id, $amount);
        }
        return $this->_api->Wallets->Get(self::$JohnsWalletWithMoney->Id);
    }

    protected function getNewWalletWithMoney($userId, $amount = 1000)
    {
        $wallet = $this->createNewWallet($userId);
        $cardRegistration = $this->createNewCardRegistration($userId);
        $this->createNewPayInCardDirect($userId, $cardRegistration->CardId, $wallet->Id, $amount);
        return $this->_api->Wallets->Get($wallet->Id);
    }

    private function createNewWallet($userId)
    {
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$userId];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR WITH MONEY';
        return $this->_api->Wallets->Create($wallet);
    }

    private function createNewCardRegistration($userId)
    {
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);
        return $this->_api->CardRegistrations->Update($cardRegistration);
    }

    private function createNewPayInCardDirect($userId, $cardId, $walletId, $amount)
    {
        // create pay-in CARD DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $walletId;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = $amount;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';

        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardId = $cardId;
        $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();

        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        // create Pay-In
        $this->_api->PayIns->Create($payIn);
    }

    /**
     * Get registration data from Payline service
     * @param \MangoPay\CardRegistration $cardRegistration
     * @return string
     */
    protected function getPaylineCorrectRegistrationData($cardRegistration)
    {

        /*
         ****** DO NOT use this code in a production environment - it is just for unit tests. In production you are not allowed to have the user's card details pass via your server (which is what is required to use this code here) *******
         */
        $data = 'data=' . $cardRegistration->PreregistrationData .
            '&accessKeyRef=' . $cardRegistration->AccessKey .
            '&cardNumber=' . Constants::CARD_FRICTIONLESS .
            '&cardExpirationDate=1229' .
            '&cardCvx=123';

        $curlHandle = curl_init($cardRegistration->CardRegistrationURL);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curlHandle);
        if ($response === false && curl_errno($curlHandle) != 0) {
            throw new \Exception('cURL error: ' . curl_error($curlHandle));
        }

        curl_close($curlHandle);

        return $response;
    }

    protected function getUpdatedCardRegistration($userId)
    {
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);

        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);

        return $this->_api->CardRegistrations->Update($cardRegistration);
    }

    /**
     * Creates mandate belonging to John
     * @return \MangoPay\Mandate
     */
    protected function getJohnsMandate()
    {
        $account = $this->getJohnsAccount();

        $mandate = new \MangoPay\Mandate();
        $mandate->Tag = "Tag test";
        $mandate->BankAccountId = $account->Id;
        $mandate->ReturnURL = "http://www.mysite.com/returnURL/";
        $mandate->Culture = "FR";

        return $this->_api->Mandates->Create($mandate);
    }

    /**
     * Creates self::$JohnsAccount (bank account belonging to John) if not created yet
     * @return \MangoPay\BankAccount
     */
    protected function getJohnsAccount()
    {
        if (self::$JohnsAccount === null || self::$JohnsAccount->Active == false) {
            $john = $this->getJohn();
            $account = new \MangoPay\BankAccount();
            $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
            $account->OwnerAddress = $john->Address;
            $account->Details = new \MangoPay\BankAccountDetailsIBAN();
            $account->Details->IBAN = 'FR7630004000031234567890143';
            $account->Details->BIC = 'BNPAFRPP';
            self::$JohnsAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);
        }
        return self::$JohnsAccount;
    }

    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\PayOut
     */
    protected function getJohnsPayOutBankWire()
    {
        if (self::$JohnsPayOutBankWire === null) {
            $wallet = $this->getJohnsWallet();
            $user = $this->getJohn();
            $account = $this->getJohnsAccount();

            $payOut = new \MangoPay\PayOut();
            $payOut->Tag = 'DefaultTag';
            $payOut->AuthorId = $user->Id;
            $payOut->CreditedUserId = $user->Id;
            $payOut->DebitedFunds = new \MangoPay\Money();
            $payOut->DebitedFunds->Currency = 'EUR';
            $payOut->DebitedFunds->Amount = 10;
            $payOut->Fees = new \MangoPay\Money();
            $payOut->Fees->Currency = 'EUR';
            $payOut->Fees->Amount = 5;

            $payOut->DebitedWalletId = $wallet->Id;
            $payOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
            $payOut->MeanOfPaymentDetails->BankAccountId = $account->Id;
            $payOut->MeanOfPaymentDetails->BankWireRef = 'Johns payment';
            $payOut->MeanOfPaymentDetails->PayoutModeRequested = 'STANDARD';

            self::$JohnsPayOutBankWire = $this->_api->PayOuts->Create($payOut);
        }

        return self::$JohnsPayOutBankWire;
    }

    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\PayOut
     */
    protected function getJohnsPayOutForCardDirect()
    {
        if (self::$JohnsPayOutForCardDirect === null) {
            $payIn = $this->getNewPayInCardDirect();
            $account = $this->getJohnsAccount();

            $payOut = new \MangoPay\PayOut();
            $payOut->Tag = 'DefaultTag';
            $payOut->AuthorId = $payIn->AuthorId;
            $payOut->CreditedUserId = $payIn->AuthorId;
            $payOut->DebitedFunds = new \MangoPay\Money();
            $payOut->DebitedFunds->Currency = 'EUR';
            $payOut->DebitedFunds->Amount = 10;
            $payOut->Fees = new \MangoPay\Money();
            $payOut->Fees->Currency = 'EUR';
            $payOut->Fees->Amount = 5;

            $payOut->DebitedWalletId = $payIn->CreditedWalletId;
            $payOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
            $payOut->MeanOfPaymentDetails->BankAccountId = $account->Id;
            $payOut->MeanOfPaymentDetails->BankWireRef = 'Johns payment';
            $payOut->MeanOfPaymentDetails->PayoutModeRequested = 'STANDARD';

            self::$JohnsPayOutForCardDirect = $this->_api->PayOuts->Create($payOut);
        }

        return self::$JohnsPayOutForCardDirect;
    }

    /**
     * Creates Pay-In Card Direct object
     * @return \MangoPay\PayIn
     */
    protected function getNewPayInCardDirect($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);
        $cardRegistration->CardHolderName = "John Silver";
        $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

        $card = $this->_api->Cards->Get($cardRegistration->CardId);

        // create pay-in CARD DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardId = $card->Id;
        $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();
        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        $payIn->ExecutionDetails->Culture = 'FR';
        $payIn->PaymentCategory = 'TelephoneOrder';

        $address = new Address();
        $address->AddressLine1 = 'Main Street no 5';
        $address->City = 'Paris';
        $address->Country = 'FR';
        $address->PostalCode = '68400';
        $address->Region = 'Europe';
        $billing = new Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $address;
        $payIn->ExecutionDetails->Billing = $billing;
        $payIn->ExecutionDetails->Requested3DSVersion = "V1";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInMbwayWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        // create pay-in MBWAY WEB
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsMbway();
        $payIn->PaymentDetails->StatementDescriptor = "test";
        $payIn->PaymentDetails->Phone = "351#269458236";
        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();

        $payIn->Tag = "test tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInGooglePayDirect($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 100;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsGooglePay();
        $payIn->PaymentDetails->StatementDescriptor = "GooglePay";
        $payIn->PaymentDetails->IpAddress = "159.180.248.187";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();
        $payIn->PaymentDetails->PaymentData = "{\"signature\":\"MEUCIQCLXOan2Y9DobLVSOeD5V64Peayvz0ZAWisdz/1iTdthAIgVFb4Hve4EhtW81k46SiMlnXLIiCn1h2+vVQGjHe+sSo\\u003d\",\"intermediateSigningKey\":{\"signedKey\":\"{\\\"keyValue\\\":\\\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEDGRER6R6PH6K39YTIYX+CpDNej6gQgvi/Wx19SOPtiDnkjAl4/LF9pXlvZYe+aJH0Dy095I6BlfY8bNBB5gjPg\\\\u003d\\\\u003d\\\",\\\"keyExpiration\\\":\\\"1688521049102\\\"}\",\"signatures\":[\"MEYCIQDup1B+rkiPAWmpg7RmqY0NfgdGhmdyL8wvAX+6C1aOU2QIhAIZACSDQ/ZexIyEia5KrRlG2B+y3AnKNlhRzumRcnNOR\"]},\"protocolVersion\":\"ECv2\",\"signedMessage\":\"{\\\"encryptedMessage\\\":\\\"YSSGK9yFdKP+mJB5+wAjnOujnThPM1E/KbbJxd3MDzPVI66ip1DBESldvQXYjjeLq6Rf1tKE9oLwwaj6u0/gU7Z9t3g1MoW+9YoEE1bs1IxImif7IQGAosfYjjbBBfDkOaqEs2JJC5qt6xjKO9lQ/E6JPkPFGqF7+OJ1vzmD83Pi3sHWkVge5MhxXQ3yBNhrjus3kV7zUoYA+uqNrciWcWypc1NndF/tiwSkvUTzM6n4dS8X84fkJiSO7PZ65C0yw0mdybRRnyL2fFdWGssve1zZFAvYfzcpNamyuZGGlu/SCoayitojmMsqe5Cu0efD9+WvvDr9PA+Vo1gzuz7LmiZe81SGvdFhRoq62FBAUiwSsi2A3pWinZxM2XbYNph+HJ5FCNspWhz4ur9JG4ZMLemCXuaybvL++W6PWywAtoiE0mQcBIX3vhOq5itv0RkaKVe6nbcAS2UryRz2u/nDCJLKpIv2Wi11NtCUT2mgD8F6qfcXhvVZHyeLqZ1OLgCudTTSdKirzezbgPTg4tQpW++KufeD7bgG+01XhCWt+7/ftqcSf8n//gSRINne8j2G6w+2\\\",\\\"ephemeralPublicKey\\\":\\\"BLY2+R8C0T+BSf/W3HEq305qH63IGmJxMVmbfJ6+x1V7GQg9W9v7eHc3j+8TeypVn+nRlPu98tivuMXECg+rWZs\\\\u003d\\\",\\\"tag\\\":\\\"MmEjNdLfsDNfYd/FRUjoJ4/IfLypNRqx8zgHfa6Ftmo\\\\u003d\\\"}\"}";

        $address = new Address();
        $address->AddressLine1 = 'Main Street no 5';
        $address->City = 'Paris';
        $address->Country = 'FR';
        $address->PostalCode = '68400';
        $address->Region = 'Europe';

        $shipping = new \MangoPay\Shipping();
        $shipping->FirstName = 'JohnS';
        $shipping->LastName = 'DoeS';
        $shipping->Address = $address;

        $payIn->PaymentDetails->Shipping = $shipping;

        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = "https://mangopay.com/docs/please-ignore";
        $payIn->ExecutionDetails->SecureMode = "DEFAULT";

        $billing = new Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $address;

        $payIn->ExecutionDetails->Billing = $billing;


        $payIn->Tag = "GooglePay tag";

        return $this->_api->PayIns->CreateGooglePay($payIn);
    }

    protected function getNewPayInMultibancoWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsMultibanco();
        $payIn->PaymentDetails->StatementDescriptor = "Multibanco";

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_8362acb9-6dbc-4660-b826-b9acb9b850b1";

        $payIn->Tag = "Multibanco tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInSatispayWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 20;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 2000;
        $payIn->DebitedFunds->Currency = 'EUR';

        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsSatispay();
        $payIn->PaymentDetails->StatementDescriptor = "Satispay";
        $payIn->PaymentDetails->Country = "IT";

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";
        $payIn->ExecutionDetails->RedirectURL = "https://r3.girogate.de/ti/satispay?tx=2085817274&rs=9SdVQk52tdbjXlFGI8xkpIR4QtpWzEFy&cs=8490cfaf68932558fd710926439b1cffa446bdbd346c42fdd63ad7fa2c56d841";

        $payIn->Tag = "Satispay tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInBlikWeb($userId = null, $withCode = false)
    {
        $john = $this->getJohn();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = 'PLN';
        $wallet->Description = 'WALLET In PLN WITH MONEY';

        $wallet = $this->_api->Wallets->Create($wallet);

        if (is_null($userId)) {
            $user = $john;
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 30;
        $payIn->Fees->Currency = 'PLN';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 3000;
        $payIn->DebitedFunds->Currency = 'PLN';

        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBlik();
        $payIn->PaymentDetails->StatementDescriptor = "Blik";

        if ($withCode) {
            $payIn->PaymentDetails->Code = "777365";
            $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();
            $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        }

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "https://example.com?transactionId=wt_57b8f69d-cbcc-4202-9a4f-9a3f3668240b";
        $payIn->ExecutionDetails->RedirectURL = "https://r3.girogate.de/ti/dumbdummy?tx=140079495229&rs=oHkl4WvsgwtWpMptWpqWlFa90j0EzzO9&cs=e43baf1ae4a556dfb823fd304acc408580c193e04c1a9bcb26699b4185393b05";

        $payIn->Tag = "Blik tag";

        return $this->_api->PayIns->Create($payIn);
    }


    protected function getNewPayInKlarnaWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsKlarna();
        $payIn->PaymentDetails->Country = "FR";
        $payIn->PaymentDetails->Culture = "FR";
        $payIn->PaymentDetails->Phone = "33#607080900";
        $payIn->PaymentDetails->Email = "mango@mangopay.com";
        $payIn->PaymentDetails->AdditionalData = "{}";
        $payIn->PaymentDetails->Reference = "afd48-879d-48fg";

        $lineItem = new LineItem();
        $lineItem->Name = 'test item';
        $lineItem->Quantity = 1;
        $lineItem->UnitAmount = 1000;
        $lineItem->TaxAmount = 0;

        $payIn->PaymentDetails->LineItems = [$lineItem];

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";

        $address = new Address();
        $address->AddressLine1 = 'Main Street no 5';
        $address->City = 'Paris';
        $address->Country = 'FR';
        $address->PostalCode = '68400';
        $address->Region = 'Europe';
        $billing = new Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $address;
        $payIn->ExecutionDetails->Billing = $billing;

        $payIn->Tag = "Klarna tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getLegacyPayInIdealWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->PaymentType = "CARD";
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->Bic = 'REVOLT21';
        $payIn->PaymentDetails->CardType = 'IDEAL';
        $payIn->PaymentDetails->StatementDescriptor = 'test';

        $payIn->ExecutionType = \MangoPay\PayInExecutionType::Web;
        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";
        $payIn->ExecutionDetails->Culture = "EN";

        $payIn->Tag = "Ideal tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInIdealWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsIdeal();
        $payIn->PaymentDetails->Bic = 'REVOLT21';
        $payIn->PaymentDetails->StatementDescriptor = 'test';

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";

        $payIn->Tag = "Ideal tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInGiropayWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsGiropay();
        $payIn->PaymentDetails->StatementDescriptor = 'test';

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";

        $payIn->Tag = "Giropay tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInSwishWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletForCurrency("SEK");
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'SEK';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 100;
        $payIn->DebitedFunds->Currency = 'SEK';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsSwish();
        $payIn->PaymentDetails->StatementDescriptor = 'test';

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";

        $payIn->Tag = "Swish tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInTwintWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletForCurrency("CHF");
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'CHF';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 100;
        $payIn->DebitedFunds->Currency = 'CHF';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsTwint();
        $payIn->PaymentDetails->StatementDescriptor = 'test twint';

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?test.com";

        $payIn->Tag = "Twint tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInBancontactWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBancontact();
        $payIn->PaymentDetails->StatementDescriptor = 'test';
        $payIn->PaymentDetails->Recurring = true;

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.my-site.com/returnURL?transactionId=wt_71a08458-b0cc-468d-98f7-1302591fc238";
        $payIn->ExecutionDetails->Culture = 'FR';

        $payIn->Tag = "Bancontact tag";

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInBizumWeb($userId = null, $usePhone = true)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 10;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBizum();
        $payIn->PaymentDetails->StatementDescriptor = 'Example123';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();

        if ($usePhone) {
            $payIn->PaymentDetails->Phone = "+34700000000";
            $payIn->Tag = "Bizum with phone tag";
        } else {
            $payIn->ExecutionDetails->ReturnURL = "https://docs.mangopay.com/please-ignore";
            $payIn->Tag = "Bizum with return url tag";
        }

        return $this->_api->PayIns->Create($payIn);
    }

    protected function getNewPayInPayByBankWeb($userId = null)
    {
        $wallet = $this->getJohnsWalletForCurrency("EUR");

        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $userId;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 100;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPayByBank();
        $payIn->PaymentDetails->StatementDescriptor = 'test';
        $payIn->PaymentDetails->Country = 'DE';
        $payIn->PaymentDetails->IBAN = 'DE03500105177564668331';
        $payIn->PaymentDetails->BIC = 'AACSDE33';
        $payIn->PaymentDetails->Scheme = 'SEPA_INSTANT_CREDIT_TRANSFER';
        $payIn->PaymentDetails->BankName = 'de-demobank-open-banking-embedded-templates';
        $payIn->PaymentDetails->PaymentFlow = 'WEB';

        // execution type as WEB
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = 'https://www.example.com';
        $payIn->ExecutionDetails->Culture = 'EN';

        $payIn->Tag = "PayByBank PHP";

        return $this->_api->PayIns->Create($payIn);
    }

    /**
     * Creates Pay-In Card Direct object
     * @return \MangoPay\PayIn
     */
    protected function getNewPayInCardDirect3DSecure($userId = null)
    {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)) {
            $user = $this->getJohn();
            $userId = $user->Id;
        }

        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);
        $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

        $card = $this->_api->Cards->Get($cardRegistration->CardId);

        // create pay-in CARD DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardId = $card->Id;
        $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();
        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        $payIn->ExecutionDetails->Culture = 'FR';

        $address = new Address();
        $address->AddressLine1 = 'Main Street no 5';
        $address->City = 'Paris';
        $address->Country = 'FR';
        $address->PostalCode = '68400';
        $address->Region = 'Europe';
        $billing = new Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $address;
        $payIn->ExecutionDetails->Billing = $billing;
        $payIn->ExecutionDetails->Requested3DSVersion = "V2_1";

        return $this->_api->PayIns->Create($payIn);
    }

    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\Transfer
     */
    protected function getNewTransfer()
    {
        $user = $this->getJohn();
        $walletWithMoney = $this->getJohnsWalletWithMoney();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$user->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR FOR TRANSFER';
        $wallet = $this->_api->Wallets->Create($wallet);

        $transfer = new \MangoPay\Transfer();
        $transfer->Tag = 'DefaultTag';
        $transfer->AuthorId = $user->Id;
        $transfer->CreditedUserId = $user->Id;
        $transfer->DebitedFunds = new \MangoPay\Money();
        $transfer->DebitedFunds->Currency = 'EUR';
        $transfer->DebitedFunds->Amount = 100;
        $transfer->Fees = new \MangoPay\Money();
        $transfer->Fees->Currency = 'EUR';
        $transfer->Fees->Amount = 0;

        $transfer->DebitedWalletId = $walletWithMoney->Id;
        $transfer->CreditedWalletId = $wallet->Id;

        return $this->_api->Transfers->Create($transfer);
    }

    protected function getNewTransferSca($userId, $amount, $scaContext, $debitedWalletId)
    {
        $matrixSca = $this->getMatrixScaOwner(false);

        $creditedWallet = new \MangoPay\Wallet();
        $creditedWallet->Owners = [$matrixSca->Id];
        $creditedWallet->Currency = 'EUR';
        $creditedWallet->Description = 'WALLET IN EUR FOR TRANSFER';
        $creditedWallet = $this->_api->Wallets->Create($creditedWallet);

        $transfer = new \MangoPay\Transfer();
        $transfer->AuthorId = $userId;
        $transfer->CreditedUserId = $matrixSca->Id;
        $transfer->DebitedFunds = new \MangoPay\Money();
        $transfer->DebitedFunds->Currency = 'EUR';
        $transfer->DebitedFunds->Amount = $amount;
        $transfer->Fees = new \MangoPay\Money();
        $transfer->Fees->Currency = 'EUR';
        $transfer->Fees->Amount = 0;

        $transfer->DebitedWalletId = $debitedWalletId;
        $transfer->CreditedWalletId = $creditedWallet->Id;
        $transfer->ScaContext = $scaContext;

        return $this->_api->Transfers->Create($transfer);
    }

    /**
     * Creates refund object for transfer
     * @return \MangoPay\Refund
     */
    protected function getNewRefundForTransfer($transfer)
    {
        $user = $this->getJohn();

        $refund = new \MangoPay\Refund();
        $refund->DebitedWalletId = $transfer->DebitedWalletId;
        $refund->CreditedWalletId = $transfer->CreditedWalletId;
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = $transfer->DebitedFunds->Amount;
        $refund->DebitedFunds->Currency = $transfer->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = $transfer->Fees->Amount;
        $refund->Fees->Currency = $transfer->Fees->Currency;

        return $this->_api->Transfers->CreateRefund($transfer->Id, $refund);
    }

    /**
     * Creates refund object for PayIn
     * @return \MangoPay\Refund
     */
    protected function getNewRefundForPayIn($payIn)
    {
        $user = $this->getJohn();

        $refund = new \MangoPay\Refund();
        $refund->CreditedWalletId = $payIn->CreditedWalletId;
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = $payIn->DebitedFunds->Amount;
        $refund->DebitedFunds->Currency = $payIn->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = $payIn->Fees->Amount;
        $refund->Fees->Currency = $payIn->Fees->Currency;

        return $this->_api->PayIns->CreateRefund($payIn->Id, $refund);
    }

    /**
     * Creates refund object for PayIn
     * @return \MangoPay\Refund
     */
    protected function getPartialRefundForPayIn($payIn)
    {
        $user = $this->getJohn();

        $refund = new \MangoPay\Refund();
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = 100;
        $refund->DebitedFunds->Currency = $payIn->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = 10;
        $refund->Fees->Currency = $payIn->Fees->Currency;

        return $this->_api->PayIns->CreateRefund($payIn->Id, $refund);
    }

    /**
     * Creates card registration object
     * @return \MangoPay\CardRegistration
     */
    protected function getJohnsCardRegistration()
    {
        if (self::$JohnsCardRegistration === null) {
            $user = $this->getJohn();

            $cardRegistration = new \MangoPay\CardRegistration();
            $cardRegistration->UserId = $user->Id;
            $cardRegistration->Currency = 'EUR';

            self::$JohnsCardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        }

        return self::$JohnsCardRegistration;
    }

    /**
     * Creates card registration object
     * @return \MangoPay\CardPreAuthorization
     */
    protected function getJohnsCardPreAuthorization($idempotencyKey = null)
    {
        $user = $this->getJohn();
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $user->Id;
        $cardRegistration->Currency = 'EUR';
        $newCardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);

        $registrationData = $this->getPaylineCorrectRegistrationData($newCardRegistration);
        $newCardRegistration->RegistrationData = $registrationData;
        $getCardRegistration = $this->_api->CardRegistrations->Update($newCardRegistration);

        $cardPreAuthorization = new \MangoPay\CardPreAuthorization();
        $cardPreAuthorization->AuthorId = $user->Id;
        $cardPreAuthorization->DebitedFunds = new \MangoPay\Money();
        $cardPreAuthorization->DebitedFunds->Currency = "EUR";
        $cardPreAuthorization->DebitedFunds->Amount = 1000;
        $cardPreAuthorization->CardId = $getCardRegistration->CardId;
        $cardPreAuthorization->SecureModeReturnURL = 'http://test.com';
        $cardPreAuthorization->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cardPreAuthorization->BrowserInfo = $this->getBrowserInfo();

        $address = new Address();
        $address->AddressLine1 = 'Main Street no 5';
        $address->City = 'Paris';
        $address->Country = 'FR';
        $address->PostalCode = '68400';
        $address->Region = 'Europe';
        $billing = new Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $address;
        $shipping = new \MangoPay\Shipping();
        $shipping->FirstName = 'JohnS';
        $shipping->LastName = 'DoeS';
        $shipping->Address = $address;
        $cardPreAuthorization->Billing = $billing;
        $cardPreAuthorization->Shipping = $shipping;
        $cardPreAuthorization->Requested3DSVersion = "V1";

        return $this->_api->CardPreAuthorizations->Create($cardPreAuthorization, $idempotencyKey);
    }

    /**
     * Creates Pay-In Card Web object
     * @return \MangoPay\PayIn
     */
    protected function getJohnsPayInPaypalWeb()
    {
        if (self::$JohnsPayInPaypalWeb === null) {
            $wallet = $this->getJohnsWallet();
            $user = $this->getJohn();

            $payIn = new \MangoPay\PayIn();
            $payIn->AuthorId = $user->Id;
            $payIn->CreditedUserId = $user->Id;
            $payIn->DebitedFunds = new \MangoPay\Money();
            $payIn->DebitedFunds->Currency = 'EUR';
            $payIn->DebitedFunds->Amount = 1000;
            $payIn->Fees = new \MangoPay\Money();
            $payIn->Fees->Currency = 'EUR';
            $payIn->Fees->Amount = 5;
            $payIn->CreditedWalletId = $wallet->Id;
            $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPaypal();
            $shippingAddress = new \MangoPay\ShippingAddress();
            $shippingAddress->RecipientName = $user->FirstName . " " . $user->LastName;
            $shippingAddress->Address = $this->getNewAddress();
            $payIn->PaymentDetails->ShippingAddress = $shippingAddress;
            $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
            $payIn->ExecutionDetails->ReturnURL = 'https://test.com';
            $payIn->ExecutionDetails->Culture = 'fr';

            self::$JohnsPayInPaypalWeb = $this->_api->PayIns->Create($payIn);
        }

        return self::$JohnsPayInPaypalWeb;
    }

    protected function getJohnsPayInPaypalWebV2()
    {
        if (self::$JohnsPayInPaypalWebV2 === null) {
            $wallet = $this->getJohnsWallet();
            $user = $this->getJohn();

            $payIn = new \MangoPay\PayIn();
            $payIn->AuthorId = $user->Id;

            $payIn->DebitedFunds = new \MangoPay\Money();
            $payIn->DebitedFunds->Currency = 'EUR';
            $payIn->DebitedFunds->Amount = 500;

            $payIn->Fees = new \MangoPay\Money();
            $payIn->Fees->Currency = 'EUR';
            $payIn->Fees->Amount = 0;

            $payIn->CreditedWalletId = $wallet->Id;
            $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPaypal();
            $address = new Address();
            $address->AddressLine1 = 'Main Street no 5';
            $address->City = 'Paris';
            $address->Country = 'FR';
            $address->PostalCode = '68400';
            $address->Region = 'Europe';

            $shipping = new \MangoPay\Shipping();
            $shipping->FirstName = 'JohnS';
            $shipping->LastName = 'DoeS';
            $shipping->Address = $address;

            $payIn->PaymentDetails->Shipping = $shipping;
            $payIn->PaymentDetails->StatementDescriptor = "test";
            $payIn->Tag = "test tag";

            $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
            $payIn->ExecutionDetails->ReturnURL = "http://example.com";
            $payIn->ExecutionDetails->Culture = "FR";

            $lineItem = new LineItem();
            $lineItem->Name = 'running shoes';
            $lineItem->Quantity = 1;
            $lineItem->UnitAmount = 500;
            $lineItem->TaxAmount = 0;
            $lineItem->Description = "seller1 ID";

            $payIn->PaymentDetails->LineItems = [$lineItem];
            $payIn->PaymentDetails->ShippingPreference = ShippingPreference::NO_SHIPPING;

            self::$JohnsPayInPaypalWebV2 = $this->_api->PayIns->CreatePayPal($payIn);
        }

        return self::$JohnsPayInPaypalWebV2;
    }

    /**
     * Creates Pay-In Card Web object
     * @return \MangoPay\PayIn
     */
    protected function getJohnsPayInPayconiqWeb()
    {
        if (self::$JohnsPayInPayconiqWeb === null) {
            $payIn = self::newPayconiqWebPayIn();
            self::$JohnsPayInPayconiqWeb = $this->_api->PayIns->Create($payIn);
        }

        return self::$JohnsPayInPayconiqWeb;
    }

    /**
     * Creates Pay-In Card Web object using the /payment-methods/payconiq endpoint
     * @return \MangoPay\PayIn
     */
    protected function getJohnsPayInPayconiqWebV2()
    {
        return $this->_api->PayIns->CreatePayconiq(self::newPayconiqWebPayIn());
    }

    private function newPayconiqWebPayIn()
    {
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();

        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $user->Id;
        $payIn->CreditedUserId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Currency = 'EUR';
        $payIn->Fees->Amount = 5;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPayconiq();
        $payIn->PaymentDetails->Country = 'BE';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = 'http://www.my-site.com/returnURL';

        return $payIn;
    }

    /**
     * Creates self::$JohnsHook
     * @return \MangoPay\Hook
     */
    protected function getJohnHook()
    {
        if (self::$JohnsHook === null) {
            $pagination = new \MangoPay\Pagination(1, 1);
            $list = $this->_api->Hooks->GetAll($pagination);

            if (isset($list[0])) {
                self::$JohnsHook = $list[0];
            } else {
                $hook = new \MangoPay\Hook();
                $hook->EventType = \MangoPay\EventType::PayinNormalCreated;
                $hook->Url = "http://test.com";
                self::$JohnsHook = $this->_api->Hooks->Create($hook);
            }
        }

        return self::$JohnsHook;
    }

    /**
     * Creates self::$Matrix (test legal user) if not created yet
     * @return \MangoPay\UserLegal
     */
    protected function getMatrix()
    {
        if (self::$Matrix === null) {
            $john = $this->getJohn();
            $user = $this->buildMatrix($john);
            self::$Matrix = $this->_api->Users->Create($user);
        }
        return self::$Matrix;
    }

    /**
     * @param $userCategory string
     * @param $recreate boolean
     * @return UserLegalSca
     * @throws Exception
     */
    protected function getMatrixSca($userCategory, $recreate)
    {
        switch ($userCategory) {
            case UserCategory::Payer:
                return $this->getMatrixScaPayer($recreate);
            case UserCategory::Owner:
                return $this->getMatrixScaOwner($recreate);
            default:
                throw new Exception('Unexpected user category');
        }
    }

    /**
     * @param $recreate boolean
     * @return UserLegalSca
     * @throws Exception
     */
    private function getMatrixScaPayer($recreate)
    {
        if (self::$MatrixScaPayer === null || $recreate) {
            $legalRepresentative = new LegalRepresentative();
            $legalRepresentative->FirstName = "John SCA";
            $legalRepresentative->LastName = "Doe SCA Review";
            $legalRepresentative->Email = "john.doe.sca@sample.org";
            $legalRepresentative->Birthday = mktime(0, 0, 0, 12, 21, 1975);
            $legalRepresentative->Nationality = "FR";
            $legalRepresentative->CountryOfResidence = "FR";
            $legalRepresentative->PhoneNumber = "+33611111111";
            $legalRepresentative->PhoneNumberCountry = "FR";

            $user = new UserLegalSca();
            $user->Name = "MartixSampleOrg";
            $user->Email = "john.doe@sample.org";
            $user->LegalPersonType = LegalPersonType::Business;
            $user->UserCategory = UserCategory::Payer;
            $user->LegalRepresentativeAddress = $this->getNewAddress();
            $user->TermsAndConditionsAccepted = true;
            $user->LegalRepresentative = $legalRepresentative;

            self::$MatrixScaPayer = $this->_api->Users->Create($user);
        }
        return self::$MatrixScaPayer;
    }

    /**
     * @param $recreate boolean
     * @return UserLegalSca
     * @throws Exception
     */
    private function getMatrixScaOwner($recreate)
    {
        if (self::$MatrixScaOwner === null || $recreate) {
            $john = $this->getJohn();

            $legalRepresentative = new LegalRepresentative();
            $legalRepresentative->FirstName = $john->FirstName;
            $legalRepresentative->LastName = "SCA Review";
            $legalRepresentative->Email = $john->Email;
            $legalRepresentative->Birthday = $john->Birthday;
            $legalRepresentative->Nationality = $john->Nationality;
            $legalRepresentative->CountryOfResidence = $john->CountryOfResidence;
            $legalRepresentative->PhoneNumber = "+33611111111";
            $legalRepresentative->PhoneNumberCountry = "FR";

            $user = new UserLegalSca();
            $user->Name = "MartixSampleOrg";
            $user->Email = $john->Email;
            $user->LegalPersonType = LegalPersonType::Business;
            $user->HeadquartersAddress = $this->getNewAddress();
            $user->UserCategory = UserCategory::Owner;
            $user->LegalRepresentativeAddress = $john->Address;
            $user->CompanyNumber = "LU123456";
            $user->TermsAndConditionsAccepted = true;
            $user->LegalRepresentative = $legalRepresentative;

            self::$MatrixScaOwner = $this->_api->Users->Create($user);
        }
        return self::$MatrixScaOwner;
    }

    /**
     * @return \MangoPay\UboDeclaration|object
     */
    public function getMatrixUboDeclaration()
    {
        if (self::$MatrixUboDeclaration === null) {
            self::$MatrixUboDeclaration = $this->_api->UboDeclarations->Create($this->getMatrix()->Id);
        }
        return self::$MatrixUboDeclaration;
    }

    public function createNewUboForMatrix()
    {
        $matrix = $this->getMatrix();
        $declaration = $this->getMatrixUboDeclaration();

        $ubo = new Ubo();
        $ubo->FirstName = "First";
        $ubo->LastName = "Last";
        $ubo->Address = $this->getNewAddress();
        $ubo->Nationality = "FR";
        $ubo->Birthday = mktime(0, 0, 0, 12, 21, 1975);
        $ubo->Birthplace = new Birthplace();
        $ubo->Birthplace->City = 'City';
        $ubo->Birthplace->Country = 'FR';

        return $ubo;
    }

    /**
     * @return Ubo|object
     */
    public function getMatrixUbo()
    {
        if (self::$MatrixUbo === null) {
            $matrix = $this->getMatrix();
            $declaration = $this->getMatrixUboDeclaration();

            $ubo = $this->createNewUboForMatrix();

            self::$MatrixUbo = $this->_api->UboDeclarations->CreateUbo($matrix->Id, $declaration->Id, $ubo);
        }
        return self::$MatrixUbo;
    }

    /**
     * Creates new user to be used for declarative purposes.
     * @return UserNatural
     */
    protected function getDeclarativeJohn()
    {
        $user = $this->buildJohn();
        $user->Capacity = \MangoPay\NaturalUserCapacity::Declarative;
        return $this->_api->Users->Create($user);
    }

    /**
     * Asserts the passed entities have identical values (by assertSame())
     * but ONLY FOR INPUT PROPERTIES, i.e. properties that are accepted by Create methods:
     * IGNORES SYSTEM PROPERTIES set by the Mango API (Id, CreationDate etc).
     *
     * @param \MangoPay\Libraries\EntityBase $entity1
     * @param \MangoPay\Libraries\EntityBase $entity2
     */
    protected function assertIdenticalInputProps($entity1, $entity2)
    {
        if (is_a($entity1, '\MangoPay\Address')) {
            $this->assertEquals($entity1->AddressLine1, $entity2->AddressLine1);
            $this->assertEquals($entity1->AddressLine2, $entity2->AddressLine2);
            $this->assertEquals($entity1->City, $entity2->City);
            $this->assertEquals($entity1->Country, $entity2->Country);
            $this->assertEquals($entity1->PostalCode, $entity2->PostalCode);
            $this->assertEquals($entity1->Region, $entity2->Region);
        } elseif (is_a($entity1, '\MangoPay\UserNatural')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->PersonType, $entity2->PersonType);
            $this->assertSame($entity1->FirstName, $entity2->FirstName);
            $this->assertSame($entity1->LastName, $entity2->LastName);
            $this->assertSame($entity1->Email, $entity2->Email);
            $this->assertNotNull($entity1->Address);
            $this->assertNotNull($entity2->Address);
            $this->assertIdenticalInputProps($entity1->Address, $entity2->Address);
            $this->assertSame($entity1->Birthday, $entity2->Birthday);
            $this->assertSame($entity1->Nationality, $entity2->Nationality);
            $this->assertSame($entity1->CountryOfResidence, $entity2->CountryOfResidence);
            $this->assertSame($entity1->Occupation, $entity2->Occupation);
            $this->assertSame($entity1->IncomeRange, $entity2->IncomeRange);
        } elseif (is_a($entity1, '\MangoPay\UserNaturalSca')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->PersonType, $entity2->PersonType);
            $this->assertSame($entity1->FirstName, $entity2->FirstName);
            $this->assertSame($entity1->LastName, $entity2->LastName);
            $this->assertSame($entity1->Email, $entity2->Email);
            $this->assertNotNull($entity1->Address);
            $this->assertNotNull($entity2->Address);
            $this->assertIdenticalInputProps($entity1->Address, $entity2->Address);
            $this->assertSame($entity1->Birthday, $entity2->Birthday);
            $this->assertSame($entity1->Nationality, $entity2->Nationality);
            $this->assertSame($entity1->CountryOfResidence, $entity2->CountryOfResidence);
            $this->assertSame($entity1->Occupation, $entity2->Occupation);
            $this->assertSame($entity1->IncomeRange, $entity2->IncomeRange);
            $this->assertSame($entity1->PhoneNumber, $entity2->PhoneNumber);
            $this->assertSame($entity1->PhoneNumberCountry, $entity2->PhoneNumberCountry);
        } elseif (is_a($entity1, '\MangoPay\UserLegal')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->PersonType, $entity2->PersonType);
            $this->assertSame($entity1->Name, $entity2->Name);
            $this->assertNotNull($entity1->HeadquartersAddress);
            $this->assertNotNull($entity2->HeadquartersAddress);
            $this->assertIdenticalInputProps($entity1->HeadquartersAddress, $entity2->HeadquartersAddress);
            $this->assertSame($entity1->LegalRepresentativeFirstName, $entity2->LegalRepresentativeFirstName);
            $this->assertSame($entity1->LegalRepresentativeLastName, $entity2->LegalRepresentativeLastName);


            //$this->assertSame($entity1->LegalRepresentativeAddress, $entity2->LegalRepresentativeAddress, "***** TEMPORARY API ISSUE: RETURNED OBJECT MISSES THIS PROP AFTER CREATION *****");
            $this->assertNotNull($entity1->LegalRepresentativeAddress);
            $this->assertNotNull($entity2->LegalRepresentativeAddress);
            $this->assertIdenticalInputProps($entity1->LegalRepresentativeAddress, $entity2->LegalRepresentativeAddress);


            $this->assertSame($entity1->LegalRepresentativeEmail, $entity2->LegalRepresentativeEmail);
            $this->assertSame($entity1->LegalRepresentativeBirthday, $entity2->LegalRepresentativeBirthday, "***** TEMPORARY API ISSUE: RETURNED OBJECT HAS THIS PROP CHANGED FROM TIMESTAMP INTO ISO STRING AFTER CREATION *****");
            $this->assertSame($entity1->LegalRepresentativeNationality, $entity2->LegalRepresentativeNationality);
            $this->assertSame($entity1->LegalRepresentativeCountryOfResidence, $entity2->LegalRepresentativeCountryOfResidence);
        } elseif (is_a($entity1, '\MangoPay\UserLegalSca')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->PersonType, $entity2->PersonType);
            $this->assertSame($entity1->Name, $entity2->Name);
            $this->assertNotNull($entity1->HeadquartersAddress);
            $this->assertNotNull($entity2->HeadquartersAddress);
            $this->assertIdenticalInputProps($entity1->HeadquartersAddress, $entity2->HeadquartersAddress);

            $this->assertNotNull($entity1->LegalRepresentativeAddress);
            $this->assertNotNull($entity2->LegalRepresentativeAddress);
            $this->assertIdenticalInputProps($entity1->LegalRepresentativeAddress, $entity2->LegalRepresentativeAddress);

            $this->assertNotNull($entity1->LegalRepresentative);
            $this->assertNotNull($entity2->LegalRepresentative);
            $this->assertIdenticalInputProps($entity1->LegalRepresentative, $entity2->LegalRepresentative);
        } elseif (is_a($entity1, '\MangoPay\BankAccount')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->UserId, $entity2->UserId);
            $this->assertSame($entity1->Type, $entity2->Type);
            $this->assertSame($entity1->OwnerName, $entity2->OwnerName);
            $this->assertNotNull($entity1->OwnerAddress);
            $this->assertNotNull($entity2->OwnerAddress);
            $this->assertIdenticalInputProps($entity1->OwnerAddress, $entity2->OwnerAddress);
            if ($entity1->Type == 'IBAN') {
                $this->assertSame($entity1->Details->IBAN, $entity2->Details->IBAN);
                $this->assertSame($entity1->Details->BIC, $entity2->Details->BIC);
            } elseif ($entity1->Type == 'GB') {
                $this->assertSame($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
                $this->assertSame($entity1->Details->SortCode, $entity2->Details->SortCode);
            } elseif ($entity1->Type == 'US') {
                $this->assertSame($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
                $this->assertSame($entity1->Details->ABA, $entity2->Details->ABA);
            } elseif ($entity1->Type == 'CA') {
                $this->assertSame($entity1->Details->BankName, $entity2->Details->BankName);
                $this->assertSame($entity1->Details->InstitutionNumber, $entity2->Details->InstitutionNumber);
                $this->assertSame($entity1->Details->BranchCode, $entity2->Details->BranchCode);
                $this->assertSame($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
            } elseif ($entity1->Type == 'OTHER') {
                $this->assertSame($entity1->Details->Type, $entity2->Details->Type);
                $this->assertSame($entity1->Details->Country, $entity2->Details->Country);
                $this->assertSame($entity1->Details->BIC, $entity2->Details->BIC);
                $this->assertSame($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
            }
        } elseif (is_a($entity1, '\MangoPay\Card')) {
            $this->assertSame($entity1->ExpirationDate, $entity2->ExpirationDate);
            $this->assertSame($entity1->Alias, $entity2->Alias);
            $this->assertSame($entity1->CardType, $entity2->CardType);
            $this->assertSame($entity1->Currency, $entity2->Currency);
        } elseif (is_a($entity1, '\MangoPay\PayIn')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->AuthorId, $entity2->AuthorId);
            $this->assertSame($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdenticalInputProps($entity1->PaymentDetails, $entity2->PaymentDetails);
            $this->assertIdenticalInputProps($entity1->ExecutionDetails, $entity2->ExecutionDetails);
        } elseif (is_a($entity1, '\MangoPay\PayInPaymentDetailsCard')) {
            $this->assertSame($entity1->CardType, $entity2->CardType);
            $this->assertSame($entity1->CardId, $entity2->CardId);
        } elseif (is_a($entity1, 'MangoPay\PayInExecutionDetailsDirect')) {
            $this->assertSame($entity1->SecureMode, $entity2->SecureMode);
            $this->assertSame($entity1->SecureModeReturnURL, $entity2->SecureModeReturnURL);
            $this->assertSame($entity1->SecureModeRedirectURL, $entity2->SecureModeRedirectURL);
        } elseif (is_a($entity1, '\MangoPay\PayInExecutionDetailsWeb')) {
            $this->assertSame($entity1->TemplateURL, $entity2->TemplateURL);
            $this->assertSame($entity1->Culture, $entity2->Culture);
            $this->assertSame($entity1->SecureMode, $entity2->SecureMode);
            $this->assertSame($entity1->RedirectURL, $entity2->RedirectURL);
            $this->assertSame($entity1->ReturnURL, $entity2->ReturnURL);
        } elseif (is_a($entity1, '\MangoPay\PayOut')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->AuthorId, $entity2->AuthorId);
            $this->assertSame($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdenticalInputProps($entity1->MeanOfPaymentDetails, $entity2->MeanOfPaymentDetails);
        } elseif (is_a($entity1, '\MangoPay\Transfer')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertSame($entity1->AuthorId, $entity2->AuthorId);
            $this->assertSame($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
        } elseif (is_a($entity1, '\MangoPay\PayOutPaymentDetailsBankWire')) {
            $this->assertSame($entity1->BankAccountId, $entity2->BankAccountId);
            $this->assertSame($entity1->BankWireRef, $entity2->BankWireRef);
        } elseif (is_a($entity1, '\MangoPay\Transaction')) {
            $this->assertSame($entity1->Tag, $entity2->Tag);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertSame($entity1->Status, $entity2->Status);
        } elseif (is_a($entity1, '\MangoPay\Money')) {
            $this->assertSame($entity1->Currency, $entity2->Currency);
            $this->assertSame($entity1->Amount, $entity2->Amount);
        } elseif (is_a($entity1, '\MangoPay\KycDocument')) {
            $this->assertSame($entity1->Type, $entity2->Type);
            $this->assertSame($entity1->Status, $entity2->Status);
            $this->assertSame($entity1->UserId, $entity2->UserId);
        } elseif (is_a($entity1, '\MangoPay\PayInPaymentDetailsPaypal')) {
            $this->assertIdenticalInputProps($entity1->ShippingAddress, $entity2->ShippingAddress);
        } elseif (is_a($entity1, '\MangoPay\ShippingAddress')) {
            $this->assertSame($entity1->RecipientName, $entity2->RecipientName);
            $this->assertIdenticalInputProps($entity1->Address, $entity2->Address);
        } elseif (is_a($entity1, '\MangoPay\LegalRepresentative')) {
            $this->assertSame($entity1->PhoneNumber, $entity2->PhoneNumber);
            $this->assertSame($entity1->PhoneNumberCountry, $entity2->PhoneNumberCountry);
            $this->assertSame($entity1->ProofOfIdentity, $entity2->ProofOfIdentity);
            $this->assertSame($entity1->FirstName, $entity2->FirstName);
            $this->assertSame($entity1->LastName, $entity2->LastName);
            $this->assertSame($entity1->Email, $entity2->Email);
            $this->assertSame($entity1->Birthday, $entity2->Birthday);
            $this->assertSame($entity1->Nationality, $entity2->Nationality);
            $this->assertSame($entity1->CountryOfResidence, $entity2->CountryOfResidence);
        } else {
            throw new \Exception("Unsupported type " . get_class($entity1));
        }
    }

    protected function getEntityFromList($entityId, $list)
    {
        foreach ($list as $entity) {
            if ($entityId == $entity->Id) {
                return $entity;
            }
        }
    }

    protected function getClientBankAccount()
    {
        $account = new BankAccount();
        $account->OwnerName = "Joe Blogs";
        $account->OwnerAddress = $this->getNewAddress();
        $account->Details = new BankAccountDetailsIBAN();
        $account->Details->IBAN = "FR7630004000031234567890143";
        $account->Details->BIC = "BNPAFRPP";
        $account->Tag = "custom meta";

        return $account;
    }

    protected function getBrowserInfo()
    {
        $browserInfo = new BrowserInfo();
        $browserInfo->AcceptHeader = "text/html, application/xhtml+xml, application/xml;q=0.9, /;q=0.8";
        $browserInfo->JavaEnabled = true;
        $browserInfo->Language = "FR-FR";
        $browserInfo->ColorDepth = 4;
        $browserInfo->ScreenHeight = 1800;
        $browserInfo->ScreenWidth = 400;
        $browserInfo->JavascriptEnabled = true;
        $browserInfo->TimeZoneOffset = "+60";
        $browserInfo->UserAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148";

        return $browserInfo;
    }

    protected function getNewDeposit($cardId, $authorId)
    {
        $deposit = new CreateDeposit();

        $deposit->AuthorId = $authorId;
        $deposit->CardId = $cardId;

        $deposit->DebitedFunds = new Money();
        $deposit->DebitedFunds->Currency = 'EUR';
        $deposit->DebitedFunds->Amount = 1000;

        $deposit->SecureModeReturnURL = "http://mangopay-sandbox-test.com";
        $deposit->StatementDescriptor = "lorem";
        $deposit->Culture = "FR";
        $deposit->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $deposit->BrowserInfo = $this->getBrowserInfo();

        $address = new Address();
        $address->AddressLine1 = 'Main Street no 5';
        $address->City = 'Paris';
        $address->Country = 'FR';
        $address->PostalCode = '68400';
        $address->Region = 'Europe';

        $billing = new Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $address;

        $deposit->Billing = $billing;
        $deposit->Shipping = $billing;

        return $deposit;
    }

    protected function getNewPayInIntentAuthorization()
    {
        $user = $this->getJohn();
        $wallet = $this->getJohnsWallet();

        $seller = new PayInIntentSeller();
        $seller->WalletId = $wallet->Id;
        $seller->AuthorId = $wallet->Owners[0];
        $seller->TransferDate = 1728133765;

        $lineItem = new PayInIntentLineItem();
        $lineItem->Seller = $seller;
        $lineItem->Sku = "item-123456";
        $lineItem->Quantity = 1;
        $lineItem->UnitAmount = 1000;

        $lineItems = [$lineItem];

        $externalData = new PayInIntentExternalData();
        $externalData->ExternalProcessingDate = 1728133765;
        $externalData->ExternalProviderReference = strval(round(microtime(true) * 1000));
        $externalData->ExternalMerchantReference = "Order-xyz-35e8490e-2ec9-4c82-978e-c712a3f5ba16";
        $externalData->ExternalProviderName = "Stripe";
        $externalData->ExternalProviderPaymentMethod = "PAYPAL";

        $buyer = new PayInIntentBuyer();
        $buyer->Id = $user->Id;

        $toCreate = new PayInIntent();
        $toCreate->Amount = 1000;
        $toCreate->Currency = CurrencyIso::EUR;
        $toCreate->ExternalData = $externalData;
        $toCreate->Buyer = $buyer;
        $toCreate->LineItems = $lineItems;

        return $this->_api->PayIns->CreatePayInIntentAuthorization($toCreate);
    }

    protected function getNewPayInIntentFullCapture()
    {
        $intentAuthorization = $this->getNewPayInIntentAuthorization();

        $externalData = new PayInIntentExternalData();
        $externalData->ExternalProcessingDate = "01-10-2024";
        $externalData->ExternalProviderReference = strval(rand(0, 999));
        $externalData->ExternalMerchantReference = "Order-xyz-35e8490e-2ec9-4c82-978e-c712a3f5ba16";
        $externalData->ExternalProviderName = "Stripe";
        $externalData->ExternalProviderPaymentMethod = "PAYPAL";

        $fullCapture = new PayInIntent();
        $fullCapture->ExternalData = $externalData;

        return $this->_api->PayIns->CreatePayInIntentCapture($intentAuthorization->Id, $fullCapture);
    }

    protected function getNewFullPayInIntentRefund()
    {
        $fullCapture = $this->getNewPayInIntentFullCapture();

        $externalData = new PayInIntentExternalData();
        $externalData->ExternalProcessingDate = 1728133765;
        $externalData->ExternalProviderReference = strval(round(microtime(true) * 1000));
        $externalData->ExternalMerchantReference = "Order-xyz-35e8490e-2ec9-4c82-978e-c712a3f5ba16";
        $externalData->ExternalProviderName = "Stripe";
        $externalData->ExternalProviderPaymentMethod = "PAYPAL";

        $refundDto = new PayInIntent();
        $refundDto->ExternalData = $externalData;

        return $this->_api->PayIns->CreatePayInIntentRefund($fullCapture->Id, $refundDto);
    }
}
