<?php

namespace Cases;

use MangoPay\IdentityVerification;
use MangoPay\Psc;
use MangoPay\Tests\Cases\Base;

/**
 * Tests basic methods for IdentityVerifications
 */
class IdentityVerificationTest extends Base
{
    public static $identityVerification;
    private static $idvIdWithPscs = "idnver_01KZXBHDH1DWC887PW6T46NVTV";
    private static $pscId = "psc_x_01KZXBT5F8FGGSK9JXGCYMNWRP";

    public function test_IdentityVerification_Create()
    {
        $identityVerification = $this->getNewIdentityVerification();
        self::assertNotNull($identityVerification);
        self::assertNotNull($identityVerification->HostedUrl);
        self::assertNotNull($identityVerification->ReturnUrl);
        self::assertEquals('PENDING', $identityVerification->Status);
    }

    public function test_IdentityVerification_Get()
    {
        $identityVerification = $this->getNewIdentityVerification();
        $fetched = $this->_api->IdentityVerifications->Get($identityVerification->Id);

        self::assertNotNull($fetched);
        self::assertEquals($identityVerification->HostedUrl, $fetched->HostedUrl);
        self::assertEquals($identityVerification->ReturnUrl, $fetched->ReturnUrl);
        self::assertEquals($identityVerification->Status, $fetched->Status);
    }

    public function test_IdentityVerification_GetAll()
    {
        $this->getNewIdentityVerification();
        $john = $this->getJohn();
        $fetched = $this->_api->IdentityVerifications->GetAll($john->Id);

        self::assertNotNull($fetched);
        self::assertTrue(is_array($fetched));
        self::assertTrue(sizeof($fetched) > 0);
    }

    public function test_IdentityVerification_GetWithPscs()
    {
        $fetched = $this->_api->IdentityVerifications->Get(self::$idvIdWithPscs);

        self::assertNotNull($fetched);
        self::assertNotNull($fetched->PSCs);
        self::assertTrue(sizeof($fetched->PSCs) > 0);
        self::assertTrue(sizeof($fetched->PSCs[0]->Data) > 0);
    }

    public function test_IdentityVerification_RetryPsc_WithoutUpdateParams()
    {
        $this->markTestSkipped("PSC must be manually invalidated before testing");

        $psc = $this->_api->IdentityVerifications->RetryPsc(self::$idvIdWithPscs, self::$pscId, new Psc());

        self::assertNotNull($psc);
        self::assertNotNull($psc->HostedUrl);
        self::assertEquals('PENDING_VALIDATION', $psc->Status);
    }

    public function test_IdentityVerification_RetryPsc_UpdateParams()
    {
        $this->markTestSkipped("PSC must be manually invalidated before testing");

        $firstName = uniqid('firstName_');
        $lastName = uniqid('lastName_');

        $pscUpdate = new Psc();
        $pscUpdate->FirstName = $firstName;
        $pscUpdate->LastName = $lastName;

        $psc = $this->_api->IdentityVerifications->RetryPsc(self::$idvIdWithPscs, self::$pscId, $pscUpdate);

        self::assertNotNull($psc);
        self::assertNotNull($psc->HostedUrl);
        self::assertEquals('PENDING_VALIDATION', $psc->Status);
        self::assertEquals($firstName, $psc->FirstName);
        self::assertEquals($lastName, $psc->LastName);
    }

    private function getNewIdentityVerification()
    {
        if (self::$identityVerification == null) {
            $john = $this->getJohn();
            $identityVerificationCreate = new IdentityVerification();
            $identityVerificationCreate->ReturnUrl = "https://example.com";
            $identityVerificationCreate->Tag = "Created by the PHP SDK";
            self::$identityVerification = $this->_api->IdentityVerifications->Create($identityVerificationCreate, $john->Id);
        }
        return self::$identityVerification;
    }
}
