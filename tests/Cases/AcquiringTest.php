<?php

namespace Cases;

use MangoPay\LineItem;
use MangoPay\Money;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsDirect;
use MangoPay\PayInExecutionDetailsWeb;
use MangoPay\PayInExecutionType;
use MangoPay\PayInPaymentDetailsApplePay;
use MangoPay\PayInPaymentDetailsCard;
use MangoPay\PayInPaymentDetailsGooglePay;
use MangoPay\PayInPaymentDetailsIdeal;
use MangoPay\PayInPaymentDetailsPaypal;
use MangoPay\PayInPaymentType;
use MangoPay\PayInStatus;
use MangoPay\PaymentData;
use MangoPay\Refund;
use MangoPay\Report;
use MangoPay\ReportFilters;
use MangoPay\Tests\Cases\Base;
use MangoPay\TransactionNature;
use MangoPay\TransactionStatus;
use MangoPay\TransactionType;
use stdClass;

class AcquiringTest extends Base
{
    private static $cardId = "placeholder";

    public function test_PayIns_Create_CardDirect()
    {
        $this->markTestSkipped("to be tested manually");
        $payIn = $this->getAcquiringPayInCardDirect();

        $this->assertNotNull($payIn);
        $this->assertEquals(PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertEquals(PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Succeeded, $payIn->Status);
    }

    public function test_PayIns_Create_IdealWeb()
    {
        $this->markTestSkipped("to be tested manually");
        $payIn = new PayIn();
        $payIn->DebitedFunds = new Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new PayInPaymentDetailsIdeal();

        $payIn->ExecutionDetails = new PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "https://mangopay.com";

        $payIn = $this->_api->Acquiring->CreatePayIn($payIn);

        $this->assertNotNull($payIn);
        $this->assertEquals(PayInPaymentType::Ideal, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsIdeal', $payIn->PaymentDetails);
        $this->assertEquals(PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
    }

    public function test_PayIns_Create_ApplePayDirect()
    {
        $this->markTestSkipped("Outdated PaymentData");
        $payIn = new PayIn();
        $payIn->DebitedFunds = new Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new PayInPaymentDetailsApplePay();
        $payIn->PaymentDetails->PaymentData = new PaymentData();
        $payIn->PaymentDetails->PaymentData->TransactionId = '061EB32181A2D9CA42AD16031B476EEBAA62A9A095AD660E2759FBA52B51A61';
        $payIn->PaymentDetails->PaymentData->Network = 'VISA';
        $payIn->PaymentDetails->PaymentData->TokenData = "{\"version\":\"EC_v1\",\"data\":\"w4HMBVqNC9ghPP4zncTA\/0oQAsduERfsx78oxgniynNjZLANTL6+0koEtkQnW\/K38Zew8qV1GLp+fLHo+qCBpiKCIwlz3eoFBTbZU+8pYcjaeIYBX9SOxcwxXsNGrGLk+kBUqnpiSIPaAG1E+WPT8R1kjOCnGvtdombvricwRTQkGjtovPfzZo8LzD3ZQJnHMsWJ8QYDLyr\/ZN9gtLAtsBAMvwManwiaG3pOIWpyeOQOb01YcEVO16EZBjaY4x4C\/oyFLWDuKGvhbJwZqWh1d1o9JT29QVmvy3Oq2JEjq3c3NutYut4rwDEP4owqI40Nb7mP2ebmdNgnYyWfPmkRfDCRHIWtbMC35IPg5313B1dgXZ2BmyZRXD5p+mr67vAk7iFfjEpu3GieFqwZrTl3\/pI5V8Sxe3SIYKgT5Hr7ow==\",\"signature\":\"MIAGCSqGSIb3DQEHAqCAMIACAQExDzANBglghkgBZQMEAgEFADCABgkqhkiG9w0BBwEAAKCAMIID5jCCA4ugAwIBAgIIaGD2mdnMpw8wCgYIKoZIzj0EAwIwejEuMCwGA1UEAwwlQXBwbGUgQXBwbGljYXRpb24gSW50ZWdyYXRpb24gQ0EgLSBHMzEmMCQGA1UECwwdQXBwbGUgQ2VydGlmaWNhdGlvbiBBdXRob3JpdHkxEzARBgNVBAoMCkFwcGxlIEluYy4xCzAJBgNVBAYTAlVTMB4XDTE2MDYwMzE4MTY0MFoXDTIxMDYwMjE4MTY0MFowYjEoMCYGA1UEAwwfZWNjLXNtcC1icm9rZXItc2lnbl9VQzQtU0FOREJPWDEUMBIGA1UECwwLaU9TIFN5c3RlbXMxEzARBgNVBAoMCkFwcGxlIEluYy4xCzAJBgNVBAYTAlVTMFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEgjD9q8Oc914gLFDZm0US5jfiqQHdbLPgsc1LUmeY+M9OvegaJajCHkwz3c6OKpbC9q+hkwNFxOh6RCbOlRsSlaOCAhEwggINMEUGCCsGAQUFBwEBBDkwNzA1BggrBgEFBQcwAYYpaHR0cDovL29jc3AuYXBwbGUuY29tL29jc3AwNC1hcHBsZWFpY2EzMDIwHQYDVR0OBBYEFAIkMAua7u1GMZekplopnkJxghxFMAwGA1UdEwEB\/wQCMAAwHwYDVR0jBBgwFoAUI\/JJxE+T5O8n5sT2KGw\/orv9LkswggEdBgNVHSAEggEUMIIBEDCCAQwGCSqGSIb3Y2QFATCB\/jCBwwYIKwYBBQUHAgIwgbYMgbNSZWxpYW5jZSBvbiB0aGlzIGNlcnRpZmljYXRlIGJ5IGFueSBwYXJ0eSBhc3N1bWVzIGFjY2VwdGFuY2Ugb2YgdGhlIHRoZW4gYXBwbGljYWJsZSBzdGFuZGFyZCB0ZXJtcyBhbmQgY29uZGl0aW9ucyBvZiB1c2UsIGNlcnRpZmljYXRlIHBvbGljeSBhbmQgY2VydGlmaWNhdGlvbiBwcmFjdGljZSBzdGF0ZW1lbnRzLjA2BggrBgEFBQcCARYqaHR0cDovL3d3dy5hcHBsZS5jb20vY2VydGlmaWNhdGVhdXRob3JpdHkvMDQGA1UdHwQtMCswKaAnoCWGI2h0dHA6Ly9jcmwuYXBwbGUuY29tL2FwcGxlYWljYTMuY3JsMA4GA1UdDwEB\/wQEAwIHgDAPBgkqhkiG92NkBh0EAgUAMAoGCCqGSM49BAMCA0kAMEYCIQDaHGOui+X2T44R6GVpN7m2nEcr6T6sMjOhZ5NuSo1egwIhAL1a+\/hp88DKJ0sv3eT3FxWcs71xmbLKD\/QJ3mWagrJNMIIC7jCCAnWgAwIBAgIISW0vvzqY2pcwCgYIKoZIzj0EAwIwZzEbMBkGA1UEAwwSQXBwbGUgUm9vdCBDQSAtIEczMSYwJAYDVQQLDB1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTETMBEGA1UECgwKQXBwbGUgSW5jLjELMAkGA1UEBhMCVVMwHhcNMTQwNTA2MjM0NjMwWhcNMjkwNTA2MjM0NjMwWjB6MS4wLAYDVQQDDCVBcHBsZSBBcHBsaWNhdGlvbiBJbnRlZ3JhdGlvbiBDQSAtIEczMSYwJAYDVQQLDB1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTETMBEGA1UECgwKQXBwbGUgSW5jLjELMAkGA1UEBhMCVVMwWTATBgcqhkjOPQIBBggqhkjOPQMBBwNCAATwFxGEGddkhdUaXiWBB3bogKLv3nuuTeCN\/EuT4TNW1WZbNa4i0Jd2DSJOe7oI\/XYXzojLdrtmcL7I6CmE\/1RFo4H3MIH0MEYGCCsGAQUFBwEBBDowODA2BggrBgEFBQcwAYYqaHR0cDovL29jc3AuYXBwbGUuY29tL29jc3AwNC1hcHBsZXJvb3RjYWczMB0GA1UdDgQWBBQj8knET5Pk7yfmxPYobD+iu\/0uSzAPBgNVHRMBAf8EBTADAQH\/MB8GA1UdIwQYMBaAFLuw3qFYM4iapIqZ3r6966\/ayySrMDcGA1UdHwQwMC4wLKAqoCiGJmh0dHA6Ly9jcmwuYXBwbGUuY29tL2FwcGxlcm9vdGNhZzMuY3JsMA4GA1UdDwEB\/wQEAwIBBjAQBgoqhkiG92NkBgIOBAIFADAKBggqhkjOPQQDAgNnADBkAjA6z3KDURaZsYb7NcNWymK\/9Bft2Q91TaKOvvGcgV5Ct4n4mPebWZ+Y1UENj53pwv4CMDIt1UQhsKMFd2xd8zg7kGf9F3wsIW2WT8ZyaYISb1T4en0bmcubCYkhYQaZDwmSHQAAMYIBizCCAYcCAQEwgYYwejEuMCwGA1UEAwwlQXBwbGUgQXBwbGljYXRpb24gSW50ZWdyYXRpb24gQ0EgLSBHMzEmMCQGA1UECwwdQXBwbGUgQ2VydGlmaWNhdGlvbiBBdXRob3JpdHkxEzARBgNVBAoMCkFwcGxlIEluYy4xCzAJBgNVBAYTAlVTAghoYPaZ2cynDzANBglghkgBZQMEAgEFAKCBlTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0xOTA1MjMxMTA1MDdaMCoGCSqGSIb3DQEJNDEdMBswDQYJYIZIAWUDBAIBBQChCgYIKoZIzj0EAwIwLwYJKoZIhvcNAQkEMSIEIIvfGVQYBeOilcB7GNI8m8+FBVZ28QfA6BIXaggBja2PMAoGCCqGSM49BAMCBEYwRAIgU01yYfjlx9bvGeC5CU2RS5KBEG+15HH9tz\/sg3qmQ14CID4F4ZJwAz+tXAUcAIzoMpYSnM8YBlnGJSTSp+LhspenAAAAAAAA\",\"header\":{\"ephemeralPublicKey\":\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE0rs3wRpirXjPbFDQfPRdfEzRIZDWm0qn7Y0HB0PNzV1DDKfpYrnhRb4GEhBF\/oEXBOe452PxbCnN1qAlqcSUWw==\",\"publicKeyHash\":\"saPRAqS7TZ4bAYwzBj8ezDDC55ZolyH1FL+Xc8fd93o=\",\"transactionId\":\"b061eb32181a2d9ca42ad16031b476eebaa62a9a095ad660e2759fba52b51a61\"}}";

        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();

        $payIn = $this->_api->Acquiring->CreatePayIn($payIn);

        $this->assertNotNull($payIn);
        $this->assertEquals(PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsApplePay', $payIn->PaymentDetails);
        $this->assertEquals(PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Succeeded, $payIn->Status);
    }

    public function test_PayIns_Create_GooglePayDirect()
    {
        $this->markTestSkipped("Outdated PaymentData");
        $payIn = new PayIn();
        $payIn->DebitedFunds = new Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new PayInPaymentDetailsGooglePay();
        $payIn->PaymentDetails->PaymentData = "{\"signature\":\"MEUCIQCLXOan2Y9DobLVSOeD5V64Peayvz0ZAWisdz/1iTdthAIgVFb4Hve4EhtW81k46SiMlnXLIiCn1h2+vVQGjHe+sSo\\u003d\",\"intermediateSigningKey\":{\"signedKey\":\"{\\\"keyValue\\\":\\\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEDGRER6R6PH6K39YTIYX+CpDNej6gQgvi/Wx19SOPtiDnkjAl4/LF9pXlvZYe+aJH0Dy095I6BlfY8bNBB5gjPg\\\\u003d\\\\u003d\\\",\\\"keyExpiration\\\":\\\"1688521049102\\\"}\",\"signatures\":[\"MEYCIQDup1B+rkiPAWmpg7RmqY0NfgdGhmdyL8wvAX+6C1aOU2QIhAIZACSDQ/ZexIyEia5KrRlG2B+y3AnKNlhRzumRcnNOR\"]},\"protocolVersion\":\"ECv2\",\"signedMessage\":\"{\\\"encryptedMessage\\\":\\\"YSSGK9yFdKP+mJB5+wAjnOujnThPM1E/KbbJxd3MDzPVI66ip1DBESldvQXYjjeLq6Rf1tKE9oLwwaj6u0/gU7Z9t3g1MoW+9YoEE1bs1IxImif7IQGAosfYjjbBBfDkOaqEs2JJC5qt6xjKO9lQ/E6JPkPFGqF7+OJ1vzmD83Pi3sHWkVge5MhxXQ3yBNhrjus3kV7zUoYA+uqNrciWcWypc1NndF/tiwSkvUTzM6n4dS8X84fkJiSO7PZ65C0yw0mdybRRnyL2fFdWGssve1zZFAvYfzcpNamyuZGGlu/SCoayitojmMsqe5Cu0efD9+WvvDr9PA+Vo1gzuz7LmiZe81SGvdFhRoq62FBAUiwSsi2A3pWinZxM2XbYNph+HJ5FCNspWhz4ur9JG4ZMLemCXuaybvL++W6PWywAtoiE0mQcBIX3vhOq5itv0RkaKVe6nbcAS2UryRz2u/nDCJLKpIv2Wi11NtCUT2mgD8F6qfcXhvVZHyeLqZ1OLgCudTTSdKirzezbgPTg4tQpW++KufeD7bgG+01XhCWt+7/ftqcSf8n//gSRINne8j2G6w+2\\\",\\\"ephemeralPublicKey\\\":\\\"BLY2+R8C0T+BSf/W3HEq305qH63IGmJxMVmbfJ6+x1V7GQg9W9v7eHc3j+8TeypVn+nRlPu98tivuMXECg+rWZs\\\\u003d\\\",\\\"tag\\\":\\\"MmEjNdLfsDNfYd/FRUjoJ4/IfLypNRqx8zgHfa6Ftmo\\\\u003d\\\"}\"}";
        $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();

        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = "https://mangopay.com";

        $payIn = $this->_api->Acquiring->CreatePayIn($payIn);

        $this->assertNotNull($payIn);
        $this->assertEquals(PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsGooglePay', $payIn->PaymentDetails);
        $this->assertEquals(PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Succeeded, $payIn->Status);
    }

    public function test_PayIns_Create_PayPalWeb()
    {
        $this->markTestSkipped("to be tested manually");
        $payIn = new PayIn();
        $payIn->DebitedFunds = new Money();
        $payIn->DebitedFunds->Amount = 100;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new PayInPaymentDetailsPaypal();
        $lineItem = new LineItem();
        $lineItem->Name = 'running shoes';
        $lineItem->Quantity = 1;
        $lineItem->UnitAmount = 100;
        $lineItem->TaxAmount = 0;
        $lineItem->Description = "seller1 ID";
        $payIn->PaymentDetails->LineItems = [$lineItem];

        $payIn->ExecutionDetails = new PayInExecutionDetailsWeb();

        $payIn = $this->_api->Acquiring->CreatePayIn($payIn);
        $this->assertNotNull($payIn);
        $this->assertEquals(PayInPaymentType::PayPal, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPaypal', $payIn->PaymentDetails);
        $this->assertEquals(PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
    }

    public function test_PayIns_Create_PayPal_DataCollection()
    {
        $this->markTestSkipped("to be tested manually");
        $dataCollection = new stdClass();
        $dataCollection->sender_account_id = "A12345N343";
        $dataCollection->sender_first_name = "Jane";
        $dataCollection->sender_last_name = "Doe";
        $dataCollection->sender_email = "jane.doe@sample.com";
        $dataCollection->sender_phone = "(042) 1123 4567";
        $dataCollection->sender_address_zip = "75009";
        $dataCollection->sender_country_code = "FR";
        $dataCollection->sender_create_date = "2012-12-09T19:14:55.277-0:00";
        $dataCollection->sender_signup_ip = "10.220.90.20";
        $dataCollection->sender_popularity_score = "high";

        $dataCollection->receiver_account_id = "A12345N344";
        $dataCollection->receiver_create_date = "2012-12-09T19:14:55.277-0:00";
        $dataCollection->receiver_email = "jane@sample.com";
        $dataCollection->receiver_address_country_code = "FR";

        $dataCollection->business_name = "Jane Ltd";
        $dataCollection->recipient_popularity_score = "high";
        $dataCollection->first_interaction_date = "2012-12-09T19:14:55.277-0:00";
        $dataCollection->txn_count_total = "34";
        $dataCollection->vertical = "Household goods";
        $dataCollection->transaction_is_tangible = "0";

        $created = $this->_api->Acquiring->CreatePayPalDataCollection($dataCollection);
        $this->assertNotNull($created);
        $this->assertNotNull($created->dataCollectionId);
    }

    public function test_PayIns_CreateRefund()
    {
        $this->markTestSkipped("to be tested manually");
        $payIn = $this->getAcquiringPayInCardDirect();
        $refund = new Refund();
        $refund->DebitedFunds = new Money();
        $refund->DebitedFunds->Amount = 10;
        $refund->DebitedFunds->Currency = "EUR";
        $result = $this->_api->Acquiring->CreatePayInRefund($payIn->Id, $refund);

        $this->assertEquals(TransactionType::PayOut, $result->Type);
        $this->assertEquals(TransactionNature::Refund, $result->Nature);
        $this->assertEquals(TransactionStatus::Succeeded, $result->Status);
    }

    public function test_Create_CardValidation()
    {
        $this->markTestSkipped("to be tested manually");
        $cardValidation = new \MangoPay\CardValidation();
        $cardValidation->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cardValidation->SecureModeReturnUrl = "http://www.example.com/";
        $cardValidation->BrowserInfo = $this->getBrowserInfo();

        $result = $this->_api->Acquiring->CreateCardValidation(self::$cardId, $cardValidation);
        $this->assertNotNull($result);
        $this->assertNotNull($result->Id);
        $this->assertNotNull($result->SecureMode);
        $this->assertNotNull($result->AuthenticationResult);
    }

    public function test_Reports_Create_Settlement()
    {
        $report = new Report();
        $report->ReportType = "ACQUIRING_SETTLEMENT";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $report->Filters = new ReportFilters();
        $report->Filters->SettlementId = "placeholder";
        $created = $this->_api->ReportsV2->Create($report);

        $this->assertNotNull($created);
        $this->assertNotNull($created->Id);
        $this->assertSame($created->ReportType, "ACQUIRING_SETTLEMENT");
        $this->assertSame($created->Status, "PENDING");
    }

    private function getAcquiringPayInCardDirect()
    {
        $this->markTestSkipped("to be tested manually");
        $payIn = new PayIn();
        $payIn->DebitedFunds = new Money();
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->DebitedFunds->Currency = 'EUR';

        $payIn->PaymentDetails = new PayInPaymentDetailsCard();
        $payIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $payIn->PaymentDetails->BrowserInfo = $this->getBrowserInfo();
        $payIn->PaymentDetails->CardId = self::$cardId;

        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = "https://mangopay.com";
        $payIn->ExecutionDetails->SecureMode = "DEFAULT";

        return $this->_api->Acquiring->CreatePayIn($payIn);
    }
}
