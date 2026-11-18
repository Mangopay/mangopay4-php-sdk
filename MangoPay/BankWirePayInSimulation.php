<?php

namespace MangoPay;

class BankWirePayInSimulation extends Libraries\Dto
{
    /**
     * The action to simulate.
     * Allowed values: ACCEPT, REJECT
     *  - ACCEPT – Simulates the arrival of funds and successful reconciliation; the pay-in Status becomes SUCCEEDED.
     *  - REJECT – Simulates the pay-in being refused for anti-fraud reasons;
     *    the pay-in Status becomes FAILED with the ResultCode 008500.
     * @var string
     */
    public $Action;
}
