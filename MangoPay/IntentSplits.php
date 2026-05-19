<?php

namespace MangoPay;

class IntentSplits extends Libraries\EntityBase
{
    /**
     * @var PayInIntentSplit[]
     */
    public $Splits;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Splits'] = ['array_single', '\MangoPay\PayInIntentSplit'];

        return $subObjects;
    }
}
