<?php

namespace MangoPay;

/**
 * API for Sandbox simulation endpoints.
 */
class ApiSimulation extends Libraries\ApiBase
{
    /**
     * Simulates the acceptance or rejection of an existing pre-declared bank wire pay-in
     * (PaymentType BANK_WIRE, ExecutionType DIRECT). Sandbox only.
     *
     * The pay-in must exist, have the Status CREATED and an Id beginning with the prefix `payin_wf_`.
     *  - ACCEPT: the pay-in Status becomes SUCCEEDED and the wallet is credited.
     *  - REJECT: the pay-in Status becomes FAILED with the ResultCode 008500.
     *
     * @param string $payInId The identifier of the pay-in
     * @param BankWirePayInSimulation $simulation The simulation request containing the Action to perform
     * @return void
     * @throws Libraries\ResponseException (with code 404 if the pay-in is not found)
     */
    public function SimulateBankWirePayIn($payInId, BankWirePayInSimulation $simulation)
    {
        $this->CreateObject('simulation_payins_bankwire', $simulation, null, $payInId);
    }

    /**
     * Simulates an incoming bank wire funding notification to a Virtual Account, such as Mangopay
     * would receive on its accounts in a Production scenario. Sandbox only.
     *
     * @param BankWireFundingSimulation $simulation The simulated incoming funds, the targeted Virtual Account
     *                                              (Creditor) and the simulated debtor/remittance information
     * @return void
     * @throws Libraries\ResponseException
     */
    public function SimulateBankWireFunding(BankWireFundingSimulation $simulation)
    {
        $this->CreateObject('simulation_payins_bankwire_funding', $simulation);
    }
}
