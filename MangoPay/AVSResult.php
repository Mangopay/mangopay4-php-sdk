<?php

namespace MangoPay;

/**
 * Address Verification System result
 */
class AVSResult
{
    public const FULL_MATCH = "FULL_MATCH";

    public const ADDRESS_MATCH_ONLY = "ADDRESS_MATCH_ONLY";

    public const POSTAL_CODE_MATCH_ONLY = "POSTAL_CODE_MATCH_ONLY";

    public const NO_MATCH = "NO_MATCH";

    public const NO_CHECK = "NO_CHECK";
}
