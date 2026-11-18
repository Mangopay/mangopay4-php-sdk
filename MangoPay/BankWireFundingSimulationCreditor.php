<?php

namespace MangoPay;

class BankWireFundingSimulationCreditor extends Libraries\Dto
{
    /**
     * The IBAN of the Virtual Account. Required.
     * @var string
     */
    public $CreditorAccount;

    /**
     * The BIC of the Virtual Account. Required.
     * @var string[]
     */
    public $CreditorAgent;
}
