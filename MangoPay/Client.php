<?php

namespace MangoPay;

/**
 * Client entity
 */
class Client extends Libraries\EntityBase
{
    /**
     * Client identifier
     * @var string
     */
    public $ClientId;

    /**
     * Name of client
     * @var string
     */
    public $Name;

    /**
     * The primary branding colour to use for your merchant
     * @var string
     */
    public $PrimaryThemeColour;

    /**
     * The primary branding colour to use for buttons for your merchant
     * @var string
     */
    public $PrimaryButtonColour;

    /**
     * The URL of the logo of your client
     * @var string
     */
    public $Logo;

    /**
     * A list of email addresses to use when contacting you for technical issues/communications
     * @var array
     */
    public $TechEmails;

    /**
     * A list of email addresses to use when contacting you for admin/commercial issues/communications
     * @var array
     */
    public $AdminEmails;

    /**
     * A list of email addresses to use when contacting you for fraud/compliance issues/communications
     * @var array
     */
    public $FraudEmails;

    /**
     * A list of email addresses to use when contacting you for billing issues/communications
     * @var string
     */
    public $BillingEmails;

    /**
     * A description of what your platform does
     * @var string
     */
    public $PlatformDescription;

    /**
     * Categorization details of the client
     * @var PlatformCategorization
     */
    public $PlatformCategorization;

    /**
     * The URL for your website
     * @var string
     */
    public $PlatformURL;

    /**
     * The address of the company’s headquarters
     * @var Address
     */
    public $HeadquartersAddress;

    /**
     * The user's headquarter's phone number
     * @var string
     */
    public $HeadquartersPhoneNumber;

    /**
     * The tax (or VAT) number for your company
     * @var string
     */
    public $TaxNumber;

    /**
     * @var string|null
     * The licensor of the platform’s company account, indicating the Mangopay entity the platform contracted with
     */
    public $Licensor;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['HeadquartersAddress'] = '\MangoPay\Address';
        $subObjects['PlatformCategorization'] = '\MangoPay\PlatformCategorization';

        return $subObjects;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'ClientId');
        array_push($properties, 'Name');
        array_push($properties, 'Logo');

        return $properties;
    }
}
