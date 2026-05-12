<?php

namespace MangoPay;

class RecurringPayInRegistration extends Libraries\EntityBase
{
    /**
     * @var string
     */
    public $Status;

    /**
     * @var string
     */
    public $ResultCode;

    /**
     * @var string
     */
    public $ResultMessage;

    /**
     * @var RecurringPayInCurrentState
     */
    public $CurrentState;

    /**
     * @var string
     */
    public $RecurringType;

    /**
     * @var Money
     */
    public $TotalAmount;

    /**
     * @var int
     */
    public $CycleNumber;

    /**
     * @var string
     */
    public $AuthorId;

    /**
     * @var string
     */
    public $CreditedUserId;

    /**
     * @var string
     */
    public $CreditedWalletId;

    /**
     * @var Billing
     */
    public $Billing;

    /**
     * @var Shipping
     */
    public $Shipping;

    /**
     * @var int Unix timestamp
     */
    public $EndDate;

    /**
     * @var string
     */
    public $Frequency;

    /**
     * @var bool
     */
    public $FixedNextAmount;

    /**
     * @var bool
     */
    public $FractionedPayment;

    /**
     * @var int
     */
    public $FreeCycles;

    /**
     * @var Money
     */
    public $FirstTransactionDebitedFunds;

    /**
     * @var Money
     */
    public $FirstTransactionFees;

    /**
     * @var Money
     */
    public $NextTransactionDebitedFunds;

    /**
     * @var Money
     */
    public $NextTransactionFees;

    /**
     * @var string
     */
    public $ProfilingAttemptReference;

    /**
     * @var string
     */
    public $PaymentType;

    /**
     * @var CardInfo
     */
    public $CardInfo;

    /**
     * @var string
     */
    public $CardId;

    /**
     * @var bool
     */
    public $Migration;

    /**
     * @var PaymentData|string
     */
    public $PaymentData;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['CurrentState'] = '\MangoPay\RecurringPayInCurrentState';
        $subObjects['TotalAmount'] = '\MangoPay\Money';
        $subObjects['CardInfo'] = '\MangoPay\CardInfo';
        $subObjects['Billing'] = '\MangoPay\Billing';
        $subObjects['Shipping'] = '\MangoPay\Shipping';
        $subObjects['FirstTransactionDebitedFunds'] = '\MangoPay\Money';
        $subObjects['FirstTransactionFees'] = '\MangoPay\Money';
        $subObjects['NextTransactionDebitedFunds'] = '\MangoPay\Money';
        $subObjects['NextTransactionFees'] = '\MangoPay\Money';

        return $subObjects;
    }
}
