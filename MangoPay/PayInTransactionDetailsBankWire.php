<?php

namespace MangoPay;

class PayInTransactionDetailsBankWire extends Libraries\Dto
{
    /**
     * @var string
     */
    public $BankTransactionDomainCode;

    /**
     * @var string
     */
    public $BankTransactionDomainFamilyCode;

    /**
     * @var string
     */
    public $BankTransactionDomainSubFamilyCode;

    /**
     * @var PayInReferences[]
     */
    public $References;

    /**
     * @var string
     */
    public $DebtorName;

    /**
     * @var string
     */
    public $DebtorAccount;

    /**
     * @var string
     */
    public $DebtorAgent;

    /**
     * @var string
     */
    public $DebtorAddressLine1;

    /**
     * @var string
     */
    public $DebtorAddressLine2;

    /**
     * @var string
     */
    public $DebtorAddressLine3;

    /**
     * @var string
     */
    public $RemittanceInformationLine1;

    /**
     * @var string
     */
    public $RemittanceInformationLine2;

    /**
     * @var string
     */
    public $RemittanceInformationLine3;

    /**
     * @var string
     */
    public $RemittanceInformationLine4;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['References'] = ['array_single', '\MangoPay\PayInReferences'];

        return $subObjects;
    }
}
