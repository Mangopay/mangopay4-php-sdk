<?php

namespace MangoPay;

/**
 * Direct debit mandate entity.
 */
class Mandate extends Libraries\EntityBase
{
    /**
     * The bank account ID to associate this mandate against
     * @var string
     */
    public $BankAccountId;

    /**
     * The type of mandate – it will be « SEPA » or « BACS »
     * but will only be completed once the mandate has been submitted
     * @var string
     */
    public $Scheme;

    /**
     * The language to use for the confirmation web page presented to your user
     * @var string
     */
    public $Culture;

    /**
     * The URL to view/download the mandate document
     * @var string
     */
    public $DocumentURL;

    /**
     * Redirect URL
     * @var string
     */
    public $RedirectURL;

    /**
     * Return URL
     * @var string
     */
    public $ReturnURL;

    /**
     * ID of the user to which this mandate belongs
     * @var string
     */
    public $UserId;

    /**
     * Status of the mandate
     * @var string
     * @see MandateStatus
     */
    public $Status;

    /**
     * The mandate result code
     * @var string
     */
    public $ResultCode;

    /**
     * The mandate result Message
     * @var string
     */
    public $ResultMessage;

    /**
     * The type of mandate: DIRECT_DEBIT
     * @var string
     */
    public $MandateType;

    /**
     * How the mandate has been created: WEB
     * @var string
     */
    public $ExecutionType;

    /**
     * The bank reference
     * @var string
     */
    public $BankReference;
}
