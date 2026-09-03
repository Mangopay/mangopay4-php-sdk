<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for KYC document list
 */
class ApiKycDocuments extends Libraries\ApiBase
{
    /**
     * Get all KYC documents
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterKycDocuments $filter Object to filter data
     * @return KycDocument[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('kyc_documents_all', $pagination, '\MangoPay\KycDocument', null, $filter, $sorting);
    }

    /**
     * Get KYC document
     * @param string $kycDocumentId Document identifier
     * @return KycDocument Document returned from API
     */
    public function Get($kycDocumentId)
    {
        return $this->GetObject('kyc_documents_get_alt', '\MangoPay\KycDocument', $kycDocumentId);
    }


    /**
     * Creates temporary URLs where each page of a KYC document can be viewed.
     *
     * @param string $kycDocumentId Identification of the document whose pages to view
     * @param Pagination $pagination Pagination object
     * @return DocumentPageConsult[] Array of consults for viewing the KYC document's pages
     * @throws Libraries\Exception
     */
    public function CreateKycDocumentConsult($kycDocumentId, & $pagination = null)
    {
        return $this->GetList('kyc_documents_create_consult', $pagination, '\MangoPay\DocumentPageConsult', $kycDocumentId, null, null);
    }
}
