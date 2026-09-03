<?php

namespace MangoPay;

/**
 * Holds enumeration of possible statuses of a declared UBO.
 */
class DeclaredUboStatus
{
    /**
     * When declaration of a UBO was created
     */
    public const Created = 'CREATED';

    /**
     * When declaration of a UBO was validated
     */
    public const Validated = 'VALIDATED';

    /**
     * When declaration of a UBO was refused
     */
    public const Refused = 'REFUSED';
}
