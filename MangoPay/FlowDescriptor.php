<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class FlowDescriptor extends Dto
{
    /**
     * Flow identifier
     * @var string
     */
    public $FlowId;

    /**
     * @var FlowDescriptorBeneficiary[]
     */
    public $Beneficiaries;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Beneficiaries'] = ['array_single', '\MangoPay\FlowDescriptorBeneficiary'];

        return $subObjects;
    }
}
