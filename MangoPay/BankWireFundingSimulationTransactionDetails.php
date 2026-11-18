<?php

namespace MangoPay;

class BankWireFundingSimulationTransactionDetails extends Libraries\Dto
{
    /**
     * The simulated sender name.
     * @var string
     */
    public $DebtorName;

    /**
     * The simulated sender account number (e.g. IBAN).
     * @var string
     */
    public $DebtorAccount;

    /**
     * The simulated sender bank code (e.g. BIC).
     * @var string
     */
    public $DebtorAgent;

    /**
     * The first line of remittance information.
     * @var string
     */
    public $RemittanceInformationLine1;

    /**
     * The second line of remittance information.
     * @var string
     */
    public $RemittanceInformationLine2;

    /**
     * The third line of remittance information.
     * @var string
     */
    public $RemittanceInformationLine3;

    /**
     * The fourth line of remittance information.
     * @var string
     */
    public $RemittanceInformationLine4;
}
