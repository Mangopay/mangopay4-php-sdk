<?php

namespace MangoPay;

class BankWireFundingSimulation extends Libraries\Dto
{
    /**
     * The simulated incoming funds. Required.
     * @var Money
     */
    public $CreditedFunds;

    /**
     * Identifies the Virtual Account targeted by the simulated wire transfer, by IBAN and BIC.
     * @var BankWireFundingSimulationCreditor
     */
    public $Creditor;

    /**
     * Simulated debtor and remittance information for the incoming bank wire.
     * @var BankWireFundingSimulationTransactionDetails
     */
    public $TransactionDetails;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['CreditedFunds'] = '\MangoPay\Money';
        $subObjects['Creditor'] = '\MangoPay\BankWireFundingSimulationCreditor';
        $subObjects['TransactionDetails'] = '\MangoPay\BankWireFundingSimulationTransactionDetails';

        return $subObjects;
    }
}
