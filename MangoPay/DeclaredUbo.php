<?php

namespace MangoPay;

/**
 * Represents validation status of a user declared as UBO.
 */
class DeclaredUbo
{
    /**
     * ID of the declared user.
     * @var string
     */
    public $UserId;

    /**
     * Validation status of this declared UBO.
     * @var string
     * @see DeclaredUboStatus
     */
    public $Status;

    /**
     * Reason why the declared UBO is not valid.
     * @var string
     * @see UboRefusedReasonType
     */
    public $RefusedReasonType;

    /**
     * Message explaining why the UBO is not valid.
     * @var string
     */
    public $RefusedReasonMessage;
}
