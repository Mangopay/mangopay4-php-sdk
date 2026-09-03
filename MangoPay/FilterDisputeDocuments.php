<?php

namespace MangoPay;

/**
 * Filter for event list
 */
class FilterDisputeDocuments extends FilterBase
{
    /**
     * @var string
     * @see DisputeDocumentStatus
     */
    public $Status;

    /**
     * @var string
     * @see DisputeDocumentType
     */
    public $Type;
}
