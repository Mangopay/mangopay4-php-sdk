<?php

namespace MangoPay;

/**
 * CardRegistration entity
 */
class CardRegistration extends Libraries\EntityBase
{
    /**
     * User Id
     * @var string
     */
    public $UserId;

    /**
     * CardType
     * @var string
     */
    public $CardType;

    /**
     * Access key
     * @var string
     */
    public $AccessKey;

    /**
     * Preregistration data
     * @var string
     */
    public $PreregistrationData;

    /**
     * Card registration URL
     * @var string
     */
    public $CardRegistrationURL;

    /**
     * Card Id
     * @var string
     */
    public $CardId;

    /**
     * Card registration data
     * @var string
     */
    public $RegistrationData;

    /**
     * The result code of the object
     * @var string
     */
    public $ResultCode;

    /**
     * The message explaining the result code
     * @var string
     */
    public $ResultMessage;

    /**
     * Currency
     * @var string
     */
    public $Currency;

    /**
     * Status
     * @var string
     * @see CardRegistrationStatus
     */
    public $Status;

    /**
     * The cardholder’s name shown on the payment card.
     * @var string
     */
    public $CardHolderName;

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'AccessKey');
        array_push($properties, 'PreregistrationData');
        array_push($properties, 'CardRegistrationURL');
        array_push($properties, 'CardId');
        array_push($properties, 'ResultCode');
        array_push($properties, 'ResultMessage');
        array_push($properties, 'Status');
        return $properties;
    }
}
