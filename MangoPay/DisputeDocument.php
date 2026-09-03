<?php

namespace MangoPay;

/**
 * Dispute document entity
 */
class DisputeDocument extends Libraries\Document
{
    /**
     * The Dispute that this document belongs to
     * @var string
     */
    public $DisputeId;

    /**
     * Type of dispute document
     * @var string
     * @see DisputeDocumentType
     */
    public $Type;

    /**
     * Status of dispute document
     * @var string
     * @see DisputeDocumentStatus
     */
    public $Status;
}
