<?php

namespace MangoPay;

class ScaStatus extends Libraries\Dto
{
    /**
     * @var string
     */
    public $UserStatus;

    /**
     * @var bool
     */
    public $IsEnrolled;

    /**
     * @var int|null
     */
    public $LastEnrollmentDate;

    /**
     * @var int|null
     */
    public $LastConsentCollectionDate;

    /**
     * @var ConsentScope|null
     */
    public $ConsentScope;
}
