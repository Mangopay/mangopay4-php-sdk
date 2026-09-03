<?php

namespace MangoPay;

/**
 * Filter for dispute document list
 */
class FilterKycDocuments extends FilterBase
{
    /**
     * @var string
     * @see KycDocumentStatus
     */
    public $Status;

    /**
     * @var string
     * @see KycDocumentType
     */
    public $Type;
}
