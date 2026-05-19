<?php

namespace MangoPay;

/**
 * Class represents Web type for 'EXTERNAL_INSTRUCTION' execution option in PayIn entity
 */
class PayInExecutionDetailsExternalInstruction extends Libraries\Dto implements PayInExecutionDetails
{
    /**
     * The ID of a banking alias.
     * @var string
     */
    public $BankingAliasId;

    /**
     * Wire reference.
     * @var string
     */
    public $WireReference;

    /**
     * Information about the account that was debited.
     * @var \MangoPay\DebitedBankAccount
     */
    public $DebitedBankAccount;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['DebitedBankAccount'] = '\MangoPay\DebitedBankAccount';

        return $subObjects;
    }
}
