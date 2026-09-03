<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for disputes
 */

/**
 * Class ApiDisputes
 * @package MangoPay
 */
class ApiDisputes extends Libraries\ApiBase
{
    /**
     * Gets dispute
     * @param string $disputeId Dispute identifier
     * @return Dispute Dispute instance returned from API
     */
    public function Get($disputeId)
    {
        return $this->GetObject('disputes_get', '\MangoPay\Dispute', $disputeId);
    }

    /**
     * Get all disputes
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterDisputes $filter Filtering object
     * @return Dispute[] Array with disputes
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_all', $pagination, '\MangoPay\Dispute', null, $filter, $sorting);
    }

    /**
     * List Disputes that need settling
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @return Dispute[] Array with disputes
     */
    public function GetPendingSettlements(& $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_pendingsettlement', $pagination, '\MangoPay\Dispute', null, null, $sorting);
    }

    /**
     * Updates dispute's tag
     * @param Dispute $dispute Dispute object to update
     * @return Dispute Transfer instance returned from API
     */
    public function Update($dispute)
    {
        return $this->SaveObject('disputes_save_tag', $dispute, '\MangoPay\Dispute');
    }

    /**
     * Contests dispute
     * @param string $disputeId Dispute identifier
     * @param Money $contestedFunds Contested funds
     * @return Dispute Dispute instance returned from API
     */
    public function ContestDispute($disputeId, $contestedFunds)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        $dispute->ContestedFunds = $contestedFunds;
        return $this->SaveObject('disputes_save_contest_funds', $dispute, '\MangoPay\Dispute');
    }

    /**
     * This method is used to resubmit a Dispute if it is reopened requiring more docs
     * @param string $disputeId Dispute identifier
     * @return Dispute Dispute instance returned from API
     */
    public function ResubmitDispute($disputeId)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        return $this->SaveObject('disputes_save_contest_funds', $dispute, '\MangoPay\Dispute');
    }

    /**
     * Close dispute
     * @param string $disputeId Dispute identifier
     * @return Dispute Dispute instance returned from API
     */
    public function CloseDispute($disputeId)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        return $this->SaveObject('dispute_save_close', $dispute, '\MangoPay\Dispute');
    }

    /**
     * Gets dispute's transactions
     * @param string $disputeId Dispute identifier
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterTransactions $filter Filtering object
     * @return Transaction[] List of Transaction instances returned from API
     * @throws Libraries\Exception
     */
    public function GetTransactions($disputeId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_get_transactions', $pagination, 'MangoPay\Transaction', $disputeId, $filter, $sorting);
    }

    /**
     * Gets dispute's documents for wallet
     * @param string $walletId Wallet identifier
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterDisputes $filter Filtering object
     * @return Dispute[] List of dispute instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDisputesForWallet($walletId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_get_for_wallet', $pagination, 'MangoPay\Dispute', $walletId, $filter, $sorting);
    }

    /**
     * Gets user's disputes
     * @param string $userId User identifier
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterDisputes $filter Filtering object
     * @return Dispute[] List of Dispute instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDisputesForUser($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_get_for_user', $pagination, 'MangoPay\Dispute', $userId, $filter, $sorting);
    }

    /**
     * Gets payin's disputes
     * @param string $payInId PayIn identifier
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterDisputes $filter Filtering object
     * @return Dispute[] List of Dispute instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDisputesForPayIn($payInId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList(
            'disputes_get_for_payin',
            $pagination,
            'MangoPay\Dispute',
            $payInId,
            $filter,
            $sorting
        );
    }

    /**
     * Gets repudiation
     * @param string $repudiationId Repudiation identifier
     * @return Repudiation Repudiation instance returned from API
     */
    public function GetRepudiation($repudiationId)
    {
        return $this->GetObject('disputes_repudiation_get', 'MangoPay\Repudiation', $repudiationId);
    }

    /**
     * Creates settlement transfer
     * @param SettlementTransfer $settlementTransfer Settlement transfer
     * @param string $repudiationId Repudiation identifier
     * @return Transfer Transfer instance returned from API
     */
    public function CreateSettlementTransfer($settlementTransfer, $repudiationId, $idempotencyKey = null)
    {
        return $this->CreateObject('disputes_repudiation_create_settlement', $settlementTransfer, '\MangoPay\Transfer', $repudiationId, null, $idempotencyKey);
    }

    /**
     * Gets settlement transfer
     * @param string $settlementTransferId Settlement transfer identifier
     * @return SettlementTransfer Transfer instance returned from API
     */
    public function GetSettlementTransfer($settlementTransferId)
    {
        return $this->GetObject('disputes_repudiation_get_settlement', '\MangoPay\SettlementTransfer', $settlementTransferId);
    }

    /**
     * Gets documents for dispute
     * @param string $disputeId Dispute identifier
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @param FilterDisputeDocuments $filter Filtering object
     * @return DisputeDocument[] List of DisputeDocument instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDocumentsForDispute($disputeId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_document_get_for_dispute', $pagination, 'MangoPay\DisputeDocument', $disputeId, $filter, $sorting);
    }

    /**
     * Update dispute document
     * @param string $disputeId Dispute identifier
     * @param DisputeDocument $disputeDocument Dispute document to save
     * @return DisputeDocument Document returned from API
     */
    public function UpdateDisputeDocument($disputeId, $disputeDocument)
    {
        return $this->SaveObject('disputes_document_save', $disputeDocument, '\MangoPay\DisputeDocument', $disputeId);
    }

    /**
     * Creates document for dispute
     * @param string $disputeId Dispute identifier
     * @param DisputeDocument $disputeDocument Dispute document to be created
     * @return DisputeDocument Dispute document returned from API
     */
    public function CreateDisputeDocument($disputeId, $disputeDocument, $idempotencyKey = null)
    {
        return $this->CreateObject('disputes_document_create', $disputeDocument, '\MangoPay\DisputeDocument', $disputeId, null, $idempotencyKey);
    }

    /**
     * Creates document's page for dispute
     * @param string $disputeId Dispute identifier
     * @param string $disputeDocumentId Dispute document identifier
     * @param DisputeDocumentPage $disputeDocumentPage Dispute document page object
     */
    public function CreateDisputeDocumentPage($disputeId, $disputeDocumentId, $disputeDocumentPage, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('disputes_document_page_create', $disputeDocumentPage, null, $disputeId, $disputeDocumentId, $idempotencyKey);
        } catch (Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }
    }

    /**
     * Creates document's page for dispute from file
     * @param string $disputeId Dispute identifier
     * @param string $disputeDocumentId Dispute document identifier
     * @param string $file File path
     * @throws Libraries\Exception
     */
    public function CreateDisputeDocumentPageFromFile($disputeId, $disputeDocumentId, $file, $idempotencyKey = null)
    {
        $filePath = $file;
        if (is_array($file)) {
            $filePath = $file['tmp_name'];
        }

        if (empty($filePath)) {
            throw new Libraries\Exception('Path of file cannot be empty');
        }

        if (!file_exists($filePath)) {
            throw new Libraries\Exception('File not exist');
        }

        $disputeDocumentPage = new DisputeDocumentPage();
        $disputeDocumentPage->File = base64_encode(file_get_contents($filePath));

        if (empty($disputeDocumentPage->File)) {
            throw new Libraries\Exception('Content of the file cannot be empty');
        }

        $this->CreateDisputeDocumentPage($disputeId, $disputeDocumentId, $disputeDocumentPage, $idempotencyKey);
    }
}
