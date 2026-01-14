<?php

namespace MangoPay\Tests\Cases;

use MangoPay\BankAccount;
use MangoPay\BankAccountDetailsOTHER;
use MangoPay\Settlement;

/**
 * Tests basic methods for Banking Aliases
 */
class SettlementsTest extends Base
{
    public static $Settlement;
    public function test_Settlements_GenerateUploadUrl()
    {
        $created = $this->createNewSettlement();
        self::assertNotNull($created);
        self::assertNotNull($created->SettlementId);
        self::assertNotNull($created->UploadUrl);
    }

    public function test_Settlements_Get()
    {
        $created = $this->createNewSettlement();
        $fetched = $this->_api->Settlements->Get($created->SettlementId);
        self::assertNotNull($fetched);
        self::assertEquals("PENDING_UPLOAD", $fetched->Status);
    }

    public function test_Settlements_GenerateNewUploadUrl()
    {
        $created = $this->createNewSettlement();
        $newDto = new Settlement();
        $newDto->FileName = 'updated_settlement_sample.csv';
        $newDto->Id = $created->SettlementId;

        $newSettlement = $this->_api->Settlements->GenerateNewUploadUrl($newDto);
        self::assertNotNull($newSettlement);
        self::assertNotNull($newSettlement->SettlementId);
        self::assertNotNull($newSettlement->UploadUrl);
    }

    public function test_UploadSettlementFile()
    {
        $created = $this->createNewSettlement();
        $file = file_get_contents(__DIR__ . '/../settlement_sample.csv');
        $curlHandle = curl_init($created->UploadUrl);

        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $file);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
            'Content-Type: text/csv',
            'Content-Length: ' . strlen($file)
        ]);

        curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        self::assertEquals(200, $httpCode);
    }

    private function createNewSettlement()
    {
        if (self::$Settlement != null) {
            return self::$Settlement;
        }
        $settlement = new Settlement();
        $settlement->FileName = 'settlement_sample.csv';
        return $this->_api->Settlements->GenerateUploadUrl($settlement);
    }
}
