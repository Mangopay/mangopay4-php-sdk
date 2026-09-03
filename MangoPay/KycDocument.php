<?php

namespace MangoPay;

/**
 * KYC document entity
 */
class KycDocument extends Libraries\Document
{
    /**
     * @var string
     * @see KycDocumentType
     */
    public $Type;

    /**
     * @var string
     * @see KycDocumentStatus
     */
    public $Status;

    /**
     * @var string
     */
    public $UserId;

    /**
     * More information regarding why the document has been rejected.
     * @var array
     */
    public $Flags;
}
