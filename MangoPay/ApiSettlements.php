<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API for settlements (API V3)
 */
class ApiSettlements extends Libraries\ApiBase
{
    /**
     * Generate a pre-signed URL to which you can upload your Mangopay-format settlement file
     *
     * @param Settlement $settlement Settlement object containing 'fileName'
     *                               (the name of your file, which can be anything you wish. The file extension must be .csv)
     * @param string $idempotencyKey Idempotency key
     * @return Settlement Object returned by the API
     * @throws Libraries\Exception
     */
    public function GenerateUploadUrl($settlement, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'settlement_generate_upload_url',
            $settlement,
            '\MangoPay\Settlement',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Retrieve the settlement data generated from file upload
     *
     * @param string $settlementId Settlement identifier
     * @return Settlement Recipient object returned from API
     * @throws Libraries\Exception
     */
    public function Get($settlementId)
    {
        return $this->GetObject('settlement_get', '\MangoPay\Settlement', $settlementId);
    }

    /**
     * Generate a new pre-signed URL to replace the file of an existing Settlement
     *
     * @param Settlement $settlement Settlement object containing 'fileName' (the name of your file, which can be
     *                               anything you wish. The file extension must be .csv),
     *                               and the 'id' (settlement identifier)
     * @return Settlement Object returned by the API
     * @throws Libraries\Exception
     */
    public function GenerateNewUploadUrl($settlement)
    {
        return $this->SaveObject(
            'settlement_generate_new_upload_url',
            $settlement,
            '\MangoPay\Settlement'
        );
    }

    /**
     * Returns all the possible errors that might have occurred with a Settlement File
     *
     * @param string $settlementId Settlement identifier
     * @param Pagination $pagination Pagination object
     * @return SettlementValidation Object returned by the API
     */
    public function GetValidations($settlementId, $pagination = null)
    {
        return $this->GetObjectWithPagination(
            'settlement_get_validations',
            '\MangoPay\SettlementValidation',
            $pagination,
            null,
            $settlementId
        );
    }
}
