<?php

namespace MangoPay;

/**
 * Event entity
 */
class Event extends Libraries\Dto
{
    /**
     * Resource ID
     * @var string
     */
    public $ResourceId;

    /**
     * Event type
     * @var EventType
     */
    public $EventType;

    /**
     * Date of event
     * @var int Unix timestamp
     */
    public $Date;
}
