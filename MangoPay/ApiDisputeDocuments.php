<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for dispute documents
 */

/**
 * Class ApiDisputeDocuments
 * @package MangoPay
 */
class ApiDisputeDocuments extends Libraries\ApiBase
{
    /**
     * Gets dispute's document
     * @param string $documentId Dispute's document identifier
     * @return DisputeDocument Dispute's document object returned from API
     */
    public function Get($documentId)
    {
        return $this->GetObject('disputes_document_get', 'MangoPay\DisputeDocument', $documentId);
    }

    /**
     * Gets dispute's documents for client
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterKycDocuments $filter Filtering object
     * @return DisputeDocument[] List of dispute documents returned from API
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_document_all', $pagination, 'MangoPay\DisputeDocument', null, $filter, $sorting);
    }

    /**
     * Creates temporary URLs where each page of a dispute document can be viewed.
     *
     * @param string $documentId Identification of the document whose pages to view
     * @param Pagination $pagination Pagination object
     * @return DocumentPageConsult[] Array of consults for viewing the dispute document's pages
     */
    public function CreateDisputeDocumentConsult($documentId, & $pagination = null)
    {
        return $this->GetList('disputes_document_create_consult', $pagination, 'MangoPay\DocumentPageConsult', $documentId, null, null);
    }
}
