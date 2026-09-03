<?php

/**
 * Created by PhpStorm.
 * User: CodegileS1
 * Date: 17.08.2017
 * Time: 12:56
 */

namespace MangoPay;

/**
 * Class represents the shipping address of a PayPal PayIn.
 */
class ShippingAddress extends Libraries\Dto
{
    /**
     * The recipient's name.
     * @var string
     */
    public $RecipientName;

    /**
     * The address.
     * @var Address
     */
    public $Address;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['Address'] = '\MangoPay\Address';

        return $subObjects;
    }
}
