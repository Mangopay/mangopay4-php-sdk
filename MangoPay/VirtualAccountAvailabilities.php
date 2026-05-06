<?php

namespace MangoPay;

class VirtualAccountAvailabilities extends Libraries\Dto
{
    /**
     * * @var VirtualAccountAvailability[]
     */
    public $Collection;

    /**
     * * @var VirtualAccountAvailability[]
     */
    public $UserOwned;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Collection'] = ['array_single', '\MangoPay\VirtualAccountAvailability'];
        $subObjects['UserOwned'] = ['array_single', '\MangoPay\VirtualAccountAvailability'];

        return $subObjects;
    }
}
