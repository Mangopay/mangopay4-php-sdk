<?php

namespace MangoPay;

/**
 * Hooks and Notifications entity
 */
class Hook extends Libraries\EntityBase
{
    /**
     * This is the URL where your receive notification for each EventType
     * @var string
     */
    public $Url;

    /**
     * @var string
     * @see \MangoPay\HookStatus
     */
    public $Status;

    /**
     * @var string
     * @see \MangoPay\HookValidity
     */
    public $Validity;

    /**
     * @var string
     * @see \MangoPay\EventType
     */
    public $EventType;

    /**
     * @var string
     */
    public $Email;
}
