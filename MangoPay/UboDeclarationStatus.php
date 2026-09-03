<?php

namespace MangoPay;

/**
 * Holds enumeration of possible UBO declaration status values.
 */
class UboDeclarationStatus
{
    /**
     * When the UBO declaration was created
     */
    public const Created = 'CREATED';

    /**
     * When validation has been requested for the UBO declaration
     */
    public const ValidationAsked = 'VALIDATION_ASKED';

    /**
     * When the UBO declaration was validated
     */
    public const Validated = 'VALIDATED';

    /**
     * When the UBO declaration was refused
     */
    public const Refused = 'REFUSED';

    public const Incomplete = 'INCOMPLETE';
}
